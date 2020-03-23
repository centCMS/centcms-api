<?php
namespace LightCloud\CentCMS\Api\Providers;

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

use Ph\{Config,};

class DispatcherServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        // register a dispatcher
        $di->setShared('dispatcher', function () {
            $evtManager = $this->getShared('eventsManager');
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($evtManager);
            $dispatcher->setDefaultNamespace("LightCloud\CentCMS\Api\Controllers\\");
            return $dispatcher;
        });
    }
}