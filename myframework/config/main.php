<?php

return [
    'basePath' => '/sites/myframework/public',
    'rootDir' => dirname(__DIR__),
    'layout' => 'layouts/main',
    'db' => [
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'dbname' => 'myframework',
        'port' => '3306',
        'user' => 'root',
        'password' => ''
    ],
    'Session'=>'Session'
];