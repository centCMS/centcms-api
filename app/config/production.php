<?php
return array(
    'application' => array(
        "name"  => "centcms-api",
        "ns"    => "LightCloud\CentCMS\Api\\",
        "mode"  => "Web",
        "staticUrl" => "/",
        "url" => "http://server.localhost.com/",
        "roles" => [
            "Guests"  => [],
            "Members" => ["Guests"],
		],
    ),
    "logger" => array(
        array(
            "filePath" => "/tmp/centcms-api.log.de",
            "level" => \Phalcon\Logger::DEBUG
        ),
        array(
            "filePath" => "/tmp/centcms-api.log",
            "level" => \Phalcon\Logger::SPECIAL
        )
    ),
    "view" => array(
        "dir" => dirname(__DIR__) . "/views/",
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
    'db' => array(
        "host" => "127.0.0.1",        
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "test",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
        "retryInterval" => 200000, // 失败重试间隔200ms
        "retryTimes" => 5, //失败重试次数
    ),
    'demoServerUrl' => array(
        "http://127.0.0.1:8001",
    ),
    'debugRPC' => false,
);