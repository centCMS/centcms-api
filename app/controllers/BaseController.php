<?php
namespace LightCloud\CentCMS\Api\Controllers;

use Phalcon\Text;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use LightCloud\CentCMS\Api\Auth\User;
use LightCloud\Com\Protos\CentCMS\Enums\CategoryStatus;

use Ph\{
    Acl, App, Dispatcher, Config, View,
};

class BaseController extends \Phalcon\Mvc\Controller
{
    protected $controller;
    protected $action;
    public $user = null;
	public $title = "";

    public function initialize()
    {
        $this->controller = $this->dispatcher->getControllerName();
        $this->action = $this->dispatcher->getActionName();
        $rand = Text::random(Text::RANDOM_ALNUM);

        $whichTitle = "页面标题(" . $this->controller . ":" . $this->action . ")";
		$title = $this->title ?: $whichTitle;
        $this->view->setVar("controller", $this->controller);
        $this->view->setVar("action", $this->action);
        $this->view->setVar("title", $title);
        $this->view->setVar("rand", $rand);
        $this->view->setVar("sidebarCategoryList", $this->categoryList());
        $this->view->setVar("categoryId", 1);
        $this->setJsVars(new \ArrayObject([
            "baseUrl"    => Config::path('application.url'),
            "staticUrl"  => Config::path('application.staticUrl'),
            "controller" => $this->controller,
            // "cateId"     => 1,
            "action"     => $this->action,
            "rand"       => $rand,
            "user"       => $this->user,
        ]));
    }

    public function setJsVars($name, $value = null)
    {
        ($this->view->setJsVars)($name, $value);
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
	
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function authroize()
    {
        $controller = Dispatcher::getControllerClass();
        $method = Dispatcher::getActiveMethod();
        return Acl::isAllowed($this->user->getRole(), $controller, $method);
    }
	
	protected function categoryList()
	{
        $request = new SimpleRequest();
        $request->setParam(1, 'id')
                ->setParam(0, 'backward')
				->setParam(CategoryStatus::PUBLISHED, 'status')
        		->setParam(2, 'depth');
        $response = App::rpc("centcms", "Category::getChildrenList", $request);
		$ret = [];
		$categoryList = $response['data'];
		foreach($categoryList as $categoryItem) {
			if($categoryItem['depth'] == 1) {
				$ret[$categoryItem['id']] = $categoryItem;
			}
		}
		foreach($categoryList as $categoryItem) {
			if($categoryItem['depth'] == 2) {
				$ret[$categoryItem['pid']]['children'][] = $categoryItem;
			}
		}
		return $ret;
	}

}