<?php

/*
 * Router
 */

class Router
{
    private static $routers = [];

    private $basePath;

    function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return mixed|string
     */
    private function getRequestURL()
    {
        $basePath = \App::getConfig()['basePath'];
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "/";
        $url = str_replace($basePath, '', $url);
        $url = $url === '' || empty($url) ? '/' : $url;
        return $url;
    }

    /**
     * @return string
     */
    private function getRequestMethod()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        return $method;
    }

    /**
     * @param  $method
     * @param  $url
     * @param  $action
     */
    public static function addRouter($method, $url, $action)
    {
        self::$routers[] = [$method, $url, $action];
    }

    /**
     * @param  $url
     * @param  $action
     */
    public static function get($url, $action)
    {
        self::addRouter('GET', $url, $action);
    }

    /**
     * @param  $url
     * @param  $action
     */
    public static function post($url, $action)
    {
        self::addRouter('POST', $url, $action);
    }

    /**
     * @param  $url
     * @param  $action
     */
    public static function any($url, $action)
    {
        self::addRouter('GET|POST', $url, $action);
    }

    public function map()
    {
        $checkRoute = false;
        $params = [];

        $requestURL = $this->getRequestURL();
        $requestMethod = $this->getRequestMethod();

        $routers = self::$routers;

        foreach ($routers as $route) {
            list($method, $url, $action) = $route;

            if (strpos($method, $requestMethod) === false) {
                continue;
            }

            if ($url === '*') {
                $checkRoute = true;
            } elseif (strpos($url, '{') === false) {
                if (strcmp(strtolower($url), strtolower($requestURL)) === 0) {
                    $checkRoute = true;
                } else {
                    continue;
                }
            } elseif (strpos($url, '}') === false) {
                continue;
            } else {
                $routeParams = explode('/', $url);
                $requestParams = explode('/', $requestURL);

                if (count($routeParams) !== count($requestParams)) {
                    continue;
                }
                foreach ($routeParams as $k => $rp) {
                    if (preg_match('/^{\w+}$/', $rp)) {
                        $params[] = $requestParams[$k];
                    }
                }
                $checkRoute = true;
            }

            if ($checkRoute === true) {
                if (is_callable($action)) {
                    call_user_func_array($action, $params);
                } elseif (is_string($action)) {
                    $this->compileRouter($action, $params);
                }
                return;
            } else {
                continue;
            }
        }
        return;
    }

    /**
     * @param $action
     * @param $params
     */
    private function compileRouter($action, $params)
    {
        if (count(explode('@', $action)) !== 2) {
            App::log('Router error');
        } else {
            $className = explode('@', $action)[0];
            $methodName = explode('@', $action)[1];

            $classNameSpace = 'app\\controllers\\' . $className;
            if (class_exists($classNameSpace)) {
                $obj = new $classNameSpace;
                App::setController($className);
                if (method_exists($classNameSpace, $methodName)) {
                    App::setAction($methodName);
                    call_user_func_array([$obj, $methodName], $params);

                } else {
                    App::log('Method "' . $methodName . '" not found');
                }
            } else {
                App::log('Class "' . $classNameSpace . '" not found');
            }
        }
    }

    function run()
    {
        $this->map();
    }

}