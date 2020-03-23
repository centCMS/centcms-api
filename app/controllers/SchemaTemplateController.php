<?php

namespace LightCloud\CentCMS\Api\Controllers;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Assert\Assertion as Assert;
use LightCloud\Com\Protos\CentCMS\Enums\SchemaTemplateStatus;
use LightCloud\Com\Protos\CentCMS\Schemas\SchemaTemplate;
use LightCloud\CentCMS\Api\Plugins\Transform;
use App\Com\Protos\ExceptionBase;
use LightCloud\Com\Protos\CentCMS\Schemas\{
    Pageable,
    RequestSchemaTemplateList,
    Id,
};
use Ph\{
	Log, Request, App,
};
class SchemaTemplateController extends BaseController
{
    /**
     * @api
     */
    public function getListPageableAction()
    {
        $name = trim(Request::getPost('name', 'string', ''));
        $pageNo = (int) Request::getPost('pageNo', 'int', 1);
        $pageSize = (int) Request::getPost('pageSize', 'int', 20);

        $request = new RequestSchemaTemplateList();
        $request->setPageable(new Pageable($pageNo, $pageSize));

        if(!empty($name)) {
            $request->setName($name);
        }
        $draw = Request::getQuery("draw", "int", 0);
        $page = App::rpc("centcms", "SchemaTemplate::getSchemaTemplateListPageable", $request);

        return Transform::pageToDataTable($page, $draw, [
            "view"   => 1,
            "edit"   => 1,
            "delete" => 1
        ]);
    }

    /**
     * @get
     * @api
     */
    public function getListAction()
    {
        $request = new SimpleRequest();
        $status = Request::get("status", "int");
        $ids = Request::get("ids", []);
		if(!is_null($status)) {
            Assert::notBlank($status);
            $request->setParam(intval($status), "status");
        }
        $request->setParam($ids, "ids");
        $result = App::rpc("centcms", "SchemaTemplate::getSchemaTemplateList", $request);
        return $result;
    }
    
    /**
     * @title("模板列表") 
     */
    public function listAction()
    {
        Log::debug("111");
    }

    /**
     * @page
     * @title("创建模板")
     */
    public function createAction()
    {
   
    }

    /**
     * @api
     * @post
     */
    public function postCreateAction()
    {
        $name = Request::getPost("name", "string");
        $identity = Request::getPost("identity", "string");
        $desc = Request::getPost("desc", "string");
        $status = Request::getPost("status", "int");
        $content = Request::getPost("content", "string");

        $creatUserId = $this->user->getId();
        $request = new SchemaTemplate();
        $request->setCreateUserId($creatUserId);
        $request->setContent(html_entity_decode($content));
        $request->setIdentity($identity);
        $request->setName($name);
        $request->setDesc($desc);
        $request->setStatus($status);

        $result = App::rpc("centcms", "SchemaTemplate::addSchemaTemplate", $request);

        return ['id' => $result];
    }

    /**
     * @page
     * @get
     */
    public function detailAction(int $id)
    {
        $request = new SimpleRequest();
        $request->setParam($id, "schemaTemplateId");
		
        $result = App::rpc("centcms", "SchemaTemplate::getSchemaTemplateDetail", $request);
        $this->view->setVar("item", $result);
        $this->setJsVars("schemaIds", [$result['id']]);
        $this->setJsVars('code', $result['content']);
    }


    public function indexAction()
    {
        
    }

    /**
     * @api
     * @get
     */
    public function getDetailAction($schemaTemplateId)
    {
        $schemaTemplateId = (int) $schemaTemplateId;
		
        $request = new SimpleRequest();
        $request->setParam($schemaTemplateId, "schemaTemplateId");
		
		$result = App::rpc("centcms", "SchemaTemplate::getSchemaTemplateDetail", $request);
		
        return $result;
    }
}
