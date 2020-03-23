<?php
namespace LightCloud\CentCMS\Api\Routes;
use Phalcon\Mvc\Router\Group as RouterGroup;

class Api extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            [
                'controller' => "index",
                'action' => "index",
                'namespace' => "LightCloud\CentCMS\Api\Controllers\\Apis",
            ]
        );

        $this->setPrefix('/apis');

        $this->add('/:controller/([a-zA-Z0-9_\-]+)/:params', [
            'controller' => 1,
            'action'     => 2,
            'params'     => 3,
            'namespace' => "LightCloud\CentCMS\Api\Controllers\\Apis",
        ])->convert('action', function ($action) {
            return lcfirst(\Phalcon\Text::camelize($action));
        })->setName('api');

    }
}