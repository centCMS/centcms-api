<?php
namespace LightCloud\CentCMS\Api\Events;
use Phalcon\Events\Event;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\Dispatcher;
use Ph\{
    EventsManager, 
    Dispatcher as PhDispatcher, Log,
    Di, Acl, Response, View, Session, Request, Annotations,
};
use App\Com\Protos\ExceptionBase;
use PhalconPlus\Contracts\{
    EventAttachable,
    Auth\Access\DispatchEvent,
};

class Dispatch implements EventAttachable, DispatchEvent
{
    public function __construct()
    {
        PhDispatcher::setEventsManager(Di::get('eventsManager'));
    }

    public function attach($param = null)
    {
        EventsManager::attach("dispatch", $this);
    }

    public function beforeDispatchLoop(Event $event, DispatcherInterface $dispatcher)
    {
        // $controller = $dispatcher->getControllerName();
        // $action = $dispatcher->getActionName();

        return true;
    }

    public function beforeExecuteRoute(Event $event, DispatcherInterface $dispatcher) : bool
    {
        // API - Let it go
        if(rtrim($dispatcher->getNamespaceName(), "\\") == "LightCloud\CentCMS\Api\Controllers\Apis") {
            return true;
        }
        
        $controller = $dispatcher->getActiveController();
        $ctrClassName = $dispatcher->getControllerClass();
        $method = $dispatcher->getActiveMethod();

        Log::debug($ctrClassName . '#####' . $method);

        if(Request::isPost()) {
            if(\method_exists($controller, "post".ucfirst($method))) {
                $dispatcher->forward([
                    'controller' => $dispatcher->getControllerName(),
                    'action' => "post".ucfirst($dispatcher->getActionName()),
                ]);
                return false;
            }
        }
        
        // Action注解分析
        $anno = Annotations::getMethod($ctrClassName, $method);

        $user = Di::get('user');
        if(!Acl::isAllowed($user->getRole(), $ctrClassName, $method)) {
            // Log::error($user->getRole() . "###" . $ctrClassName . "###" .  $method);
            if($user->isGuest()) {
				$from = urlencode(Request::getURI());
                Response::redirect('/user/login?from='.$from);
            } else {
                if($anno->has('api')) {
                    ExceptionBase::throw('您没有权限');
                } else {
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action'     => 'show403'
                    ));
                }
            }
            return false;
        }

        if(method_exists($controller, 'setUser')) {
            // Log::debug(var_export($user, true));
            $controller->setUser($user);
        }
        if($anno->has('title')) {
            $controller->setTitle($anno->get('title')->getArgument(0));
        }
        if($anno->has('disableView') || $anno->has('api')) {
            View::disable();
        }

        return true;
    }

    public function afterExecuteRoute(Event $event, DispatcherInterface $dispatcher)
    {
        $returnValue = $dispatcher->getReturnedValue();
        if(is_object($returnValue) && ($returnValue instanceof \Phalcon\Http\Response)) {
            return true;
        }
        if(!is_array($returnValue) && !is_object($returnValue)) {
            return true;
        }
        if (is_object($returnValue)) {
            if(method_exists($returnValue, "getResult")) {
                $returnValue = $returnValue->getResult();
            } else if(method_exists($returnValue, "toArray")) {
                $returnValue = $returnValue->toArray();
            }
        } 
        $return = [
            'errorCode' => 0,
            'data' => $returnValue,
            'errorMsg' => '',
            'sessionId' => Session::getId(),
        ];
        Response::setContentType("application/json", "UTF-8");
        Response::setJsonContent($return, \JSON_UNESCAPED_UNICODE);
        $dispatcher->setReturnedValue(Response::itself());
        return true;
    }

    public function beforeForward(Event $event, DispatcherInterface $dispatcher, array $forward)
    {
        $dispatcher->setNamespaceName("LightCloud\CentCMS\Api\Controllers\\");
    }

    public function beforeException(Event $event, DispatcherInterface $dispatcher, \Exception $exception)
    {
        $ctrClassName = $dispatcher->getControllerClass();
        $method = $dispatcher->getActiveMethod();
        
        // Action注解分析
        $anno = Annotations::getMethod($ctrClassName, $method);

        if(rtrim($dispatcher->getNamespaceName(), "\\") == "LightCloud\CentCMS\Api\Controllers\Apis") {
            throw $exception;
        }
        if($anno->has('api')) {
            throw $exception;
        }
        
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward(array(
                    'controller' => 'error',
                    'action'     => 'show404'
                ));
                return false;
            default:
                $dispatcher->forward(array(
                    'controller' => 'error',
                    'action'     => 'showUnknown',
                    "params"     => [$exception],
                ));
                return false;
        }
    }
}