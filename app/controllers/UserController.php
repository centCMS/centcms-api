<?php
namespace LightCloud\CentCMS\Api\Controllers;
use LightCloud\CentCMS\Api\Auth\{
	OAuth, User
};
use Ph\{
	Session, App, Request, Response,
};
class UserController extends BaseController
{
    public function indexAction()
    {
        echo "It works.";
    }
	
	public function loginAction()
	{
		$url = (new OAuth())->authorizeCodeUrl(["user"]);
		
		$this->view->setVar('oAuthUrl', $url);
		
		Session::set("from", urldecode(Request::getQuery("from", "string", "/")));
	}
	
	public function logoutAction()
	{
		User::logout();
		
		Response::redirect("/user/login");
		return Response::itself();
	}
}