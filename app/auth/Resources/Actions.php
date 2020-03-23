<?php
namespace LightCloud\CentCMS\Api\Auth\Resources;
use Ph\Acl;
use Phalcon\Acl\Resource as AclResource;
use PhalconPlus\Contracts\Auth\Access\ResourceAware;
use LightCloud\CentCMS\Api\Controllers\{
    IndexController,
    ErrorController,
	UserController,
	OAuthController,
    CategoryController,
    SchemaTemplateController,
    ItemController,
    AboutController,
};

class Actions implements ResourceAware
{
    public function register()
    {
        foreach(glob(APP_MODULE_DIR."/app/controllers/*.php") as $filename) {
            $className = basename($filename, ".php");
            if($className == 'BaseController' || $className == 'ControllerBase') {
                continue;
            }
            $classNameWithNs = "LightCloud\\CentCMS\\Api\\Controllers\\".$className;
            $resource = new AclResource($classNameWithNs);
            $methods = get_class_methods($classNameWithNs);
            foreach($methods as $method) {
                if(substr($method, -6) == 'Action') {
                    Acl::addResource($resource, $method);
                }
            }
        }
        return $this;
    }

    public function control()
    {
        Acl::allow('Guests', ErrorController::class, '*');
        Acl::allow('Guests', UserController::class, 'loginAction');
        Acl::allow('Guests', OAuthController::class, '*');
        Acl::allow('Guests', AboutController::class, '*');
        Acl::allow('Guests', SchemaTemplateController::class, 'indexAction');
        Acl::allow('Guests', ItemController::class, 'indexAction');
        Acl::allow('Guests', ItemController::class, 'detailAction');
        
        
        Acl::allow('Members', IndexController::class, '*');  
        Acl::allow('Members', UserController::class, 'logoutAction');
        Acl::allow('Members', SchemaTemplateController::class, 'listAction');
        Acl::allow('Members', SchemaTemplateController::class, 'detailAction');
        Acl::allow('Members', SchemaTemplateController::class, 'createAction');
        Acl::allow('Members', SchemaTemplateController::class, 'getDetailAction');
        Acl::allow('Members', SchemaTemplateController::class, 'getListPageableAction');
        Acl::allow('Members', SchemaTemplateController::class, 'postCreateAction');
        Acl::allow('Members', SchemaTemplateController::class, 'getListAction');

        Acl::allow('Members', CategoryController::class, '*');
        Acl::allow('Members', ItemController::class, '*');
        return $this;
    }
}