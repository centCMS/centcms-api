<?php
namespace LightCloud\CentCMS\Api\Events;

use App\Com\Protos\ExceptionBase;
use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application as PhApp;
use Phalcon\Acl\Role;
use Ph\{
    EventsManager, App, Di, Acl, Router, Log, Cookies,
    Annotations, View, Session, Config, Request, Security,
}; 
use LightCloud\CentCMS\Api\Auth\Resources\{
    Actions, Routes
};
use LightCloud\CentCMS\Api\Auth\User;
use PhalconPlus\Contracts\{
    EventAttachable,
};

class AppHandler implements EventAttachable
{
    const TOKEN_KEY_SESSION_ID = '$PHALCON/CSRF/KEY$';

    public function __construct()
    {
        // 
    }

    public function attach($param = null)
    {
        EventsManager::attach("application", $this);
    }

    public function boot(Event $event, PhApp $app)
    {
        foreach(Config::path('application.roles') as $role => $inheritList) {
            Acl::addRole(new Role($role));
            foreach($inheritList as $roleToInherit) {
                Acl::addInherit($role, $roleToInherit);
            }
        }
        try {
            (new Actions())->register()->control();
            (new Routes())->register()->control();
        } catch(\Exception $e) {
            throw $e;       
        }   
    }

    public function beforeHandleRequest(Event $event, PhApp $application, Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerClass();
        $method = $dispatcher->getActiveMethod();
        // Action注解分析
        $anno = Annotations::getMethod($controller, $method);

        Session::start();
        if(Request::has('sessionId')) {
            Session::setId(Request::get('sessionId')); 
        }
        if(Request::isAjax() || !Request::isGet()) {
            if(Request::has(Session::get(AppHandler::TOKEN_KEY_SESSION_ID))) {
                Log::debug("hit security check...###".Security::getSessionToken());
                if(!Security::checkToken()) {
                    ExceptionBase::throw("Token is request is not mathed");
                }
            } else {
                if(!User::checkCookieToken()) {
                    ExceptionBase::throw("Token in cookie is not valide");
                }
            }
        }
        // Check user login
        User::checkLogin();
        // 禁止模板, DispatchLoop
        // if($anno->has('disableView') || $anno->has('api')) {
        //     View::disable();
        // }
        if($anno->has('disableGuests')) {
            Acl::deny("Guests", $controller, $method);
        }
        if($anno->has('allowGuests')) {
            Acl::allow("Guests", $controller, $method);
        }
    }

    public function beforeSendResponse(Event $event, PhApp $application, Response $response)
    {
        $csrfToken = Security::getTokenKey().','.Security::getToken();
        $cookieName = Config::path("application.cookie.token_name");
        $response->setHeader("X-CSRF-TOKEN", $csrfToken);
        $crypted = App::crypt()->encryptBase64(Security::getToken(), null, true);
        Cookies::set($cookieName, $crypted);
    }

}