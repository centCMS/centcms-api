<?php
namespace LightCloud\CentCMS\Api\Events;

use Phalcon\Events\Event;
use Phalcon\Mvc\Application as PhApp;
use PhalconPlus\App\Driver\AppDriver as AppDriver;
use PhalconPlus\App\App as SupApp;
use Ph\{
    EventsManager, App, Di, Acl, Router,
    Annotations, View, Session, Config, Request, Security,
}; 
use ITIL\Exceptions\Handler as ExceptionHandler;
use ITIL\Auth\Resources\{
    Actions, Models, Routes
};
use PhalconPlus\Contracts\{
    EventAttachable,
};

class SuperApp implements EventAttachable
{
    public function __construct()
    {
        App::setEventsManager(Di::get('eventsManager'));
    }

    public function attach($param = null)
    {
        EventsManager::attach("superapp", $this);
    }

    public function beforeStartDriver(Event $event, SupApp $app, array $context)
    {
        //
        

    }

    public function afterStartDriver(Event $event, SupApp $app, AppDriver $driver)
    {
        // var_dump($driver);
        // $driver->getHandler()->setEventsManager(Di::get('eventsManager'));
    }
}