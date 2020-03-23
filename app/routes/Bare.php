<?php
namespace LightCloud\CentCMS\Api\Routes;
use Phalcon\Mvc\Router\Group as RouterGroup;

class Bare extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            [
                'controller' => "index",
                'action' => "index",
                'namespace' => "LightCloud\CentCMS\Api\Controllers",
            ]
        );
        $this->add('/:controller/([a-zA-Z0-9_\-]+)/:params', array(
            'controller' => 1,
            'action'     => 2,
            'params'     => 3,
            'namespace' => "LightCloud\CentCMS\Api\Controllers",
        ))->convert('action', function ($action) {
            return lcfirst(\Phalcon\Text::camelize($action)); // foo-bar -> fooBar
        });
    
        $this->add('/:controller', array(
            'controller' => 1,
            'action' => 'index',
            'namespace' => "LightCloud\CentCMS\Api\Controllers",
        ));
		
        $this->add('/oauth/callback', array(
            'controller' => 'o-auth',
            'action' => 'callback',
            'namespace' => "LightCloud\CentCMS\Api\Controllers",
        ));
    
        $this->add('/', array(
            'controller' => 'index',
            'action' => 'index',
            'namespace' => "LightCloud\CentCMS\Api\Controllers",
        ));
    }
}
    