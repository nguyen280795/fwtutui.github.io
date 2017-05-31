<?php

/*
 * Model
 */

class Model
{
    function __construct()
    {
        $app = \App::getConfig()['db'];
        $this->db = new Database($app['type'], $app['host'], $app['dbname'], $app['user'], $app['password']);
    }
}