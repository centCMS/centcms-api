<?php
namespace LightCloud\CentCMS\Api\Auth;

use PhalconPlus\Contracts\Auth\{
    Access\Authorizable
};
use Phalcon\Text;
use PhalconPlus\Auth\UserProvider;
use LightCloud\CentCMS\Api\Auth\OAuth;

use Ph\{
    Config, Session, Acl, Request, App, 
    Di, Security, Cookies, Log,
};

class User extends UserProvider implements Authorizable
{
    const SESSNAME_PATH = "application.cookie.session_name";
	
	public function __construct($id = 0, $name = "", $role = "Guests")
	{
        $this->id = intval($id);
        $this->name = $name ?: Text::random(Text::RANDOM_ALNUM);
        $this->role = $role;
	}
	
    public static function getById(string $userId) : UserProvider
    {
        $cookieName = Config::path(User::SESSNAME_PATH);
        $user = json_decode(Session::get($cookieName."_info"), true);
        if (!empty($user)) {
            return new User($user['id'], $user['username'], "Members");
        } else {
            return User::guest();
        }
    }

    public function hasAccess(string $roleName) : bool
    {
        $roles = Config::path('application.roles')->toArray();
        return $roleName == $this->getRole() || 
                in_array($roleName, $roles[$this->getRole()], true);
    }

    public function isSuper()
    {
        return $this->getRole() == 'Super';
    }

    public function isGuest()
    {
        return $this->getRole() == 'Guests';
    }

    public function isMember()
    {
        return $this->getRole() == 'Members';
    }

    public function isAdmin()
    {
        return $this->getRole() == 'Admin';
    }

    public static function checkLogin() : bool
    {
        $cookieName = Config::path(User::SESSNAME_PATH);
        if(Session::has($cookieName)) {
            $userId = intval(Session::get($cookieName));
        } else {
			$userId = 0;
			if(true == User::checkLoginWithOAuth()) {
				$userId = Session::get($cookieName);
			}
        }
        $user = User::getById($userId);
        Di::setShared("user", $user);
        if($user->isGuest()) {
            Session::remove($cookieName);
            return false;
        }
        return true;
    }
	
    public static function checkLoginWithOAuth() : bool
    {
		try {
			$user = (new OAuth())->getUserInfo();
	    } catch(\Exception $e) {
	    	return false;
	    }
		$cookieName = Config::path(User::SESSNAME_PATH);		
		Session::set($cookieName, $user->data['id']);
        Session::set($cookieName.'_info', json_encode($user->data));
		return true;
    }

    public static function checkCookieToken() : bool
    {
        $cookieName = Config::path("application.cookie.token_name");
        $decrypted = App::crypt()->decryptBase64(Cookies::get($cookieName), null, true);
        return Security::getSessionToken() == $decrypted;
    }
	
	public static function logout()
	{
		Session::destroy();
	}

    public static function checkLoginWithToken() : bool
    {
		return true;
    }

    public function can(string $ability, $param) : bool
    {
        return false;
    }
}