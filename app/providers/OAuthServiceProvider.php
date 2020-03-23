<?php
namespace LightCloud\CentCMS\Api\Providers;

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use PhalconPlus\Curl\Curl as HttpClient;

use Ph\{Config, Security};

class OAuthServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $di->set("oauth", function($name) {
			$baseUrl = Config::path("{$name}.addresses.0");
            return (new HttpClient())
                        ->setBaseUrl($baseUrl)
                        ->setDefaultHeaders([
                            'Accept' => 'application/json',
                        ]);
        });
    }
}