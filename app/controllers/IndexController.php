<?php
namespace LightCloud\CentCMS\Api\Controllers;
use PhalconPlus\Base\SimpleRequest;
use Ph\{
	Response, App, Di, View
};
class IndexController extends BaseController
{
    /**
	 * @title("控制台")
	 */
    public function indexAction()
    {
        $result = App::rpc("centcms", "Dummy::statistics");
        $this->view->setVar("count", $result);
        $partialJsList = (array) View::getVar("partialJs");
        
        $partialJsList[] = '/vendor/raphael/raphael.min.js';
        $partialJsList[] = '/vendor/morrisjs/morris.min.js';
        $partialJsList[] = '/data/morris-data.js';

        View::setVar("partialJs", $partialJsList);
    }
}