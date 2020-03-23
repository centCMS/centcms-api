<?php
namespace LightCloud\CentCMS\Api\Controllers;
use LightCloud\CentCMS\Api\Auth\OAuth;
use Ph\{
	App, Security, Session, Log,
};

class OAuthController extends BaseController
{
    public function callbackAction()
    {		
		$state1 = App::request()->getQuery("state");
		$state2 = Session::get("oauthState", null, true);
		Log::debug($state1 . "##########" . $state2);
		if($state1 == $state2) {
			$code = urldecode(App::request()->getQuery('code'));
			$o = new OAuth();
			$o->getAccessTokenByCode($code);
			App::response()->redirect(Session::get("from", "/", true));
			return App::response();
		} else {
			throw new \Exception(1);
		}
    }
}