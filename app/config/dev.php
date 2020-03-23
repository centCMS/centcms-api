<?php
return [
    'application' => [
        "name"  => "centcms-api",
        "ns"    => "LightCloud\CentCMS\Api\\",
        "mode"  => "Web",
        "key"   => "wJ5AjbUTO1AGMMl72vo7ORkzmyT25pSL",
        "cookie" => [
            "session_name" => "identity",
            "token_name" => "centcms_api_token",
        ],
        "staticUrl" => "/assets",
        "url" => "http://127.0.0.1:8200",
        "roles" => [
            "Guests"  => [],
            "Members" => ["Guests"],
		],
    ],
    "logger" => [
        [
            "filePath" => $def->getDir()."/var/log/centcms-api.log.debug",
            "level" => \Phalcon\Logger::DEBUG
        ],
        [
            "filePath" => $def->getDir()."/var/log/centcms-api.log",
            "level" => \Phalcon\Logger::SPECIAL
        ]
    ],
    "view" => [
        "dir" => dirname(__DIR__) . "/views/",
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ],
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
    "session" => [
        "uniqueId"   => "lightcloud-centcms-api",
        "host"       => "127.0.0.1",
        "port"       => 6379,
        "auth"       => "",
        "persistent" => false,
        "lifetime"   => 3600,
        "prefix"     => "my",
        "index"      => 0,
    ],
    'uc' => [
		'name' => 'uc',
        'addresses' => [
            "http://127.0.0.1:8181/oauth",
        ]
    ],
    'rpc' => [
        "centcms" => [
            "debug"  => false,
            "module" => "centcms-backend",
			"namePrefix" => "LightCloud\CentCMS\Backend\Services\\",
            "addresses"  => [
                "http://localhost:8201",
            ],
        ],
    ],
];