<?php
namespace LightCloud\CentCMS\Api;

use PhalconPlus\App\Module\AbstractModule as AppModule;
use LightCloud\CentCMS\Api\Providers\ServiceProvider;

use Ph\{
    Config, Di, App, Sys, 
};

class Module extends AppModule
{
    public function registerAutoloaders()
    {
        Di::get('loader')->registerNamespaces([
            __NAMESPACE__.'\\Controllers\\Apis' => __DIR__.'/controllers/apis/',
            __NAMESPACE__.'\\Controllers' => __DIR__.'/controllers/',
            __NAMESPACE__.'\\Providers'   => __DIR__.'/providers/',
            __NAMESPACE__.'\\Plugins'     => __DIR__.'/plugins/',
            __NAMESPACE__.'\\Routes'      => __DIR__.'/routes/',
            __NAMESPACE__.'\\Auth'        => __DIR__.'/auth/',
            __NAMESPACE__.'\\Events'      => __DIR__.'/events/',
            __NAMESPACE__.'\\Exceptions'  => __DIR__.'/exceptions/',
            "LightCloud\Com\Protos"       => Sys::getCommonDir().'/protos/',
        ], true)->register();
    }
    
    public function registerServices()
    {
        Di::register(new ServiceProvider($this));
    }

    public function registerEvents()
    {
        if($this->isPrimary()) {
            // Attach Events
            (new \LightCloud\CentCMS\Api\Events\Provider())->attach();
        }
    }
}