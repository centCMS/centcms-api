<?php

namespace LightCloud\CentCMS\Api\Controllers;

use PhalconPlus\Assert\Assertion as Assert;
use PhalconPlus\Base\{
    SimpleResponse,
    SimpleRequest,
};
use LightCloud\CentCMS\Api\Plugins\Transform;
use LightCloud\Com\Protos\CentCMS\Enums\CategoryStatus;
use LightCloud\Com\Protos\CentCMS\Schemas\{
    Pageable,
    Id,
    Category as CategorySchema,
};

use Ph\{
	App, Log, Request
};

class CategoryController extends BaseController
{
    public function indexAction()
    {

    }

    public function createAction()
    {
        $result = App::rpc("centcms", "Category::getRoot");
        $this->view->setVar('category', $result);
        
    }

	/**
	 * @api
	 */
    public function postCreateAction()
    {
        $name = trim(Request::getPost('name', 'string'));
        $parentId = (int) Request::getPost('parentId', 'int');
        $identity = trim(Request::getPost('identity', 'string'));

        Assert::minLength($name, 2);
        Assert::min($parentId, 1);
        Assert::betweenLength($identity, 4, 32);

        $desc = trim($this->request->getPost('desc', 'string'));
        $status = (int) $this->request->getPost('status', 'int');
        $sortNo = $this->request->getPost('sortNo', 'int');

        $request = new CategorySchema();
        $request->setName($name);
        $request->setParentId($parentId);
        $request->setIdentity($identity);
        $request->setDesc($desc);

        if (!is_null($status)) {
            Assert::integer($status);
            $request->setStatus($status);
        }
        if (!is_null($sortNo)) {
            Assert::integer($sortNo);
            $request->setSortNo($sortNo);
        }
		
        $result = App::rpc("centcms", "Category::addCategory", $request);

        return (new SimpleResponse())->setItem($result, "categoryId");
    }

    /**
     * @title("分类列表")
     */
    public function listAction($categoryId)
    {
        $categoryId = intval($categoryId);
        Assert::integer($categoryId);
        Assert::min($categoryId, 1);
		
        $request = new Id();
        $request->setId($categoryId);
		
        $category = App::rpc("centcms", "Category::getCategoryDetail", $request);
        $this->view->setVar("categoryId", $categoryId);
        $this->view->setVar("category", $category);
        $this->setJsVars("cateId", $categoryId);
        
        $parents = App::rpc("centcms", "Category::getParentsByCategoryId", $request);
        $this->view->setVar("parents", $parents);
    }

    public function getTopCategoryAction()
    {
		return App::rpc("centcms", "Category::getTopCategory");
    }

    /**
     * @api
     */
    public function getListAction()
    {
        $categoryId = (int) Request::get('categoryId', 'int', 1);
        $backward = (bool) Request::get('backward', 'int', 0);
        $onlyDirectChild = (int) Request::get('onlyDirectChild', 'int', 0);
        $status = (int) Request::get('status', 'int', CategoryStatus::PUBLISHED);

        $request = (new SimpleRequest())
                     ->setParam($categoryId, 'id')
                     ->setParam($backward, 'backward')
                     ->setParam($status, 'status');
		
        if ($onlyDirectChild != 1) {
            $request->setParam(2, 'depth');
        }

        $result = App::rpc("centcms", "Category::getChildrenList", $request);
        $tmp = array_column($result["data"], null, "id");
        $new = [];
        foreach($tmp as $idx => $item) {
            if($item['pid'] == $categoryId) {
                $new[$idx] = $item;
            }
        }
        foreach($tmp as $idx => $item) {
            if($item['pid'] != $categoryId) {
                $pid = $item['pid'];
                if(isset($new[$pid])) {
                    $new[$pid]['children'][] = $item;
                }
            }
        }
        return $new;
    }

    /**
     * @api
     */
    public function getListPageableAction()
    {
        $categoryId = (int) Request::get('categoryId');
        $backward = (bool) Request::get('backward', 'int', 0);
        $name = trim(Request::get('name'));

        $draw = Request::get("draw", "int", 0);        
        $pageable = Transform::cursorToPageable(Request::get());

        $request = (new SimpleRequest())
        		    ->setParam($categoryId, "id")
					->setParam($backward, "backward")
					->setParam($name, "name")
					->setParam($pageable, "pageable");
		
        $page = App::rpc("centcms", "Category::getChildrenList", $request);
		Log::debug(\json_encode($page));
        return Transform::pageToDataTable($page, $draw, [
            "view"   => 1,
            "edit"   => 1,
            "delete" => 1
        ]);
    }

    /**
     * @api
     */
    public function getDetailAction($categoryId)
    {
        $categoryId = (int) $categoryId;
        Assert::integer($categoryId);
        Assert::min($categoryId, 1);
		
        $request = new Id();
        $request->setId($categoryId);
        		
        $response = App::rpc("centcms", "Category::getCategoryDetail", $request);
		
        return $response;
    }

    // 获取某个类型最新的数据
    public function getLatestDataAction()
    {
        $categoryIdentity = $this->request->get('categoryIdentity');
        Assert::isString($categoryIdentity);
        Assert::minLength($categoryIdentity, 4);

        $request = new SimpleRequest();
        $request->setParam($categoryIdentity, 'identity');
		
        $response = App::rpc("centcms", "Category::getLatestDataByCategoryIdentity", $request);
		
        return $response;
     
    }

    /**
     * @OAuth("centcms.data centcms.category")
     * 
     * 获取某个分类下的所有数据带分页
     */
    public function getDataByCategoryPageableAction()
    {
        $categoryIdentity = Request::get('categoryIdentity');
        $pageNo = (int) Request::get('pageNo', 'int', 1);
        $pageSize = (int) Request::get('pageSize', 'int', 30);

        Assert::isString($categoryIdentity);
        Assert::min($pageNo, 1);
        Assert::min($pageSize, 1);

        $pageNo = min(1, $pageNo);
        $pageSize = min(30, $pageSize);

        $request = (new SimpleRequest())
					->setParam($categoryIdentity, 'identity')
        			->setParam(new Pageable($pageNo, $pageSize), 'pageable');
		
        $response = App::rpc("centcms", "Category::getDataByCategoryPageable", $request);
		
        return $response;
     
    }
}
