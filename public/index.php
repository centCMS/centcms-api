<?php
use PhalconPlus\Bootstrap;

try {
    $app = (new Bootstrap(dirname(__DIR__)))->app();
    $response = $app->handle();
} catch(Throwable $e) {
    LightCloud\CentCMS\Api\Exceptions\Handler::catch($e);
    if(isset($app)) {
        $response = $app->response();
    } else {
        throw $e;
    }
}
$response->send();
$app->terminate();
