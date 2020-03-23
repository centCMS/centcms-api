<?php
namespace LightCloud\CentCMS\Api\Controllers;
use PhalconPlus\Assert\Assertion as Assert;
use PhalconPlus\Base\SimpleResponse;

use LightCloud\CentCMS\Api\Plugins\Transform;
use LightCloud\Com\Protos\CentCMS\Schemas\{
    Pageable,
    RequestItemList,
    Id,
    Item as ItemSchema,
};

use Ph\{
	App, Log, Request, Response,
};

class ItemController extends BaseController
{
    /**
     * @title("数据列表")
     */
    public function listAction($categoryId)
    {
        $categoryId = (int) $categoryId;
        $this->setJsVars("cateId", $categoryId);
        $this->view->setVar("categoryId", $categoryId);

        $request = new Id();
        $request->setId($categoryId);
        
        $parents = App::rpc("centcms", "Category::getParentsByCategoryId", $request);
        $this->view->setVar("parents", $parents);

        $category = App::rpc("centcms", "Category::getCategoryDetail", $request);
        $this->view->setVar("category", $category);

        // $schemas = App::rpc("centcms", "SchemaTemplate::getSchemaTemplateList");
        // $this->view->setVar("schema", $schemas);
    }

    /**
     * @title("新增数据")
     */
    public function createAction()
    {
        $categoryId = (int) Request::get("categoryId", "int", 1);
        Assert::integer($categoryId);
        Assert::min($categoryId, 1);
		
        $request = new Id();
        $request->setId($categoryId);
		
        $category = App::rpc("centcms", "Category::getCategoryDetail", $request);
        $this->view->setVar("categoryId", $categoryId);
        $this->view->setVar("category", $category);
    }

    /**
     * @api
     */
    public function getListPageableAction()
    {
        $categoryId = (int) Request::get('categoryId', "int", 0);   
        
        $draw = Request::get("draw", "int", 0);

        $pageable = Transform::cursorToPageable(Request::get());
        
        $request = new RequestItemList();
        $request->setCategoryId($categoryId);

        $search = Request::get("search", "string", "");
        if(!empty($search['value'])) {
            $request->setName($search['value']);
        }
        $request->setPageable($pageable);

        $page = App::rpc("centcms", "Item::getItemList", $request);
        return Transform::pageToDataTable($page, $draw, [
            "view"   => 1,
            "edit"   => 1,
            "delete" => 1
        ]);
    }

    /**
     * @api
     */
    public function getDetailAction($itemId)
    {
        $itemId = (int) $itemId;
        
		$request = new Id();
        $request->setId($itemId);
		
        $response = App::rpc("centcms", "Item::getItemDetail", $request);
		
        return $response;
    }

    public function detailAction($itemId)
    {
        $itemId = (int) $itemId;
		$request = new Id();
        $request->setId($itemId);
		
        $result = App::rpc("centcms", "Item::getItemDetail", $request);
        $this->view->setVar("item", $result);
        $this->setJsVars('code', $result['content']);
    }

    public function indexAction()
    {
        $this->setJsVars("cateId", 1);
    }
    /**
     * @api
     */
    public function postCreateAction()
    {
        $name = trim(Request::getPost('name'));
        $categoryId = (int) Request::getPost('categoryId');
        $identity = trim(Request::getPost('identity'));
        $schemaTemplateId = (int) Request::getPost('schemaTemplateId');
        $content = trim(Request::getPost('content'));
		
        // $enableSchedule = (int) Request::getPost('enableSchedule');
        // $schedule = trim(Request::getPost('schedule'));

        Assert::notEmpty($name);
        Assert::minLength($name, 6);
        Assert::min($categoryId, 1);
        Assert::notEmpty($identity);
        Assert::minLength($identity, 4);
        Assert::min($schemaTemplateId, 1);
        Assert::isJsonString($content);

        $request = new ItemSchema();
        $request->setName($name);
        $request->setCategoryId($categoryId);
        $request->setIdentity($identity);
        $request->setSchemaTemplateId($schemaTemplateId);
        $request->setCreateUserId($this->user->getId()); // mock user
        $request->setContent($content);

        $desc   = Request::getPost('desc');
        $status = Request::getPost('status');
        $sortNo = Request::getPost('sortNo');
		
        if(!is_null($status)) {
            Assert::numeric($status);
            $request->setStatus(intval($status));
        }
        if(!is_null($sortNo)) {
            Assert::numeric($sortNo);
            $request->setSortNo($sortNo);
        }
		
        $request->setDesc($desc);
        
        $response = App::rpc("centcms", "Item::addItem", $request);
		
        return (new SimpleResponse())->setItem($response, "itemId");
    }
}