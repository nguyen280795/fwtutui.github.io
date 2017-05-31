<?php

/*
 * Auto
 */

class AutoLoad
{
    private $rootDir;

    function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
        spl_autoload_register([$this, 'autoLoad']);

        $this->autoLoadFile();
    }

    /**
     * @param $class
     */
    private function autoLoad($class)
    {
        $fileName = explode('\\', $class);
        $fileName = end($fileName);
        $filePath = $this->rootDir . '\\' . strtolower(str_replace($fileName, '', $class)) . $fileName . '.php';

        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            App::log("$class does not exists");
        }
    }

    private function autoLoadFile()
    {
        foreach ($this->defaultFileLoad() as $file) {
            require_once($this->rootDir . '/' . $file);
        }
    }

    /**
     * @return array
     */
    private function defaultFileLoad()
    {
        return [
            'app/core/Router.php',
            'app/core/Model.php',
            'app/core/Database.php',
            'app/routers.php',
            'app/libs/Log.php',
            'app/libs/Session.php',
//            'app/libs/SessionDB.php'
        ];
    }
}