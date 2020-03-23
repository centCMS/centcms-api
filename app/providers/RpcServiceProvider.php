<?php
namespace LightCloud\CentCMS\Api\Providers;

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use PhalconPlus\Base\SimpleRequest;
use PhalconPlus\RPC\Client\Adapter\{
    Local as LocalRpc,
    Curl as RemoteRpc
};
use PhalconPlus\Base\ProtoBuffer;
use App\Com\Protos\ExceptionBase;
use Ph\{Config, App, Log};

class RpcServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di) : void
    {
        $di->set("rpc", function($name, $service, $args=[]) {
            $client = null;
            $config = Config::path("rpc.{$name}");
            if($config->debug == true) {
                App::dependModule($config->module); // 可能需要修改
                $client = new LocalRpc($this);
            } else {
                $remoteUrls = $config->addresses;
                $client = new RemoteRpc($remoteUrls->toArray(), [
                    \CURLOPT_CONNECTTIMEOUT	=> 3, // seconds
                ]);
            }
			
			$client->setNamePrefix(Config::path("rpc.{$name}.namePrefix"));
            
            $request = null;
	        if(is_object($args) && $args instanceof ProtoBuffer) {
	            $request = $args;
	        } elseif(is_array($args) && !empty($args)) {
	            $request = new SimpleRequest();
	            $request->setParams($args);
	        }
			[$service, $method] = explode("::", $service);
	        $response = $client->callByObject([
	            "service" => $service,
	            "method"  => $method,
	            "args"    => $request,
	            "logId"   => Log::getProcessorVar("logId"),
            ]);
            if($response["errorCode"] != 0) {
                ExceptionBase::throw($response["errorMsg"], $response["errorCode"]);
            }
            return $response["data"];
        });
    }
}