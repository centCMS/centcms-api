<?php
namespace LightCloud\CentCMS\Api\Controllers;

use Ph\{
	Router,
};

class ErrorController extends BaseController
{
    public function show404Action()
    {
        $this->view->setVar("notFoundUrl", Router::getRewriteUri());
    }

    public function show403Action()
    {
        $this->view->setVar("forbiddenUrl", Router::getRewriteUri());
    }

    public function showUnknownAction()
    {
        $params = $this->dispatcher->getParams();
		
        $e = empty($params) ? new \Exception("Unknown Exception", 10001) : $params[0];
		
		$this->view->setVar("e", $e);
    }
}