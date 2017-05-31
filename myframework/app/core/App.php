<?php

require_once(dirname(__FILE__) . '/AutoLoad.php');

/*
 * App
 */

class App
{
    private $router;

    //create public static @param
    public static $config;
    public static $controller;
    private static $action;

    function __construct()
    {
        new AutoLoad(self::$config['rootDir']);

        $this->router = new Router(self::$config['basePath']);
    }

    /**
     * @param $config
     */
    public static function setConfig($config)
    {
        self::$config = $config;
    }

    /**
     * @return mixed
     */
    public static function getConfig()
    {
        return self::$config;
    }

    /**
     * @param $controller
     */
    public static function setController($controller)
    {
        self::$controller = $controller;
    }

    /**
     * @return mixed
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * @param $action
     */
    public static function setAction($action)
    {
        self::$action = $action;
    }

    /**
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * @param $log
     */
    public static function log($log)
    {
        $logMs = new Log();
        $logMs->log($log);
    }

    public function run()
    {
        $this->router->run();
    }
}