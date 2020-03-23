<?php
namespace LightCloud\CentCMS\Api\Events;
use Ph\{
    EventsManager,
    ModelsManager,
    Di,
};
use ITIL\Auth\Model as AuthModel;
use ITIL\Auth\User;
use PhalconPlus\Contracts\{
    EventAttachable,
};

class Model implements EventAttachable
{
    public function __construct()
    {
        ModelsManager::setEventsManager(Di::get('eventsManager'));
    }

    /**
     * @param param User
     */
    public function attach($param = null)
    {
        $user = Di::has('user') ? Di::get('user') : User::guest();
        EventsManager::attach("model", new AuthModel($user));
    }
}