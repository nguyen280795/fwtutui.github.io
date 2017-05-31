<?php

namespace app\core;

use \App;

/*
 * Controller
 */

class Controller
{
    private $layout = 'null';

    public function __construct()
    {
        $this->layout = App::getConfig()['layout'];
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param $url
     * @param $isEnd
     * @param $responseCode
     */
    public function redirect($url, $isEnd = true, $responseCode = 302)
    {
        header('Location:' . $url, true, $responseCode);
        if ($isEnd)
            die();
    }

    /**
     * @param $view
     * @param $data
     * @return string
     */
    public function getViewContent($view, $data)
    {
        $controller = App::getController();
        $folderView = strtolower(str_replace('Controller', '', $controller));
        $rootDir = App::getConfig()['rootDir'];
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'Database');
        } else {
            $data = $data;
        }
        $viewPath = $rootDir . '/app/views/' . $folderView . '/' . $view . '.php';
        if (file_exists(($viewPath))) {
            ob_start();
            require($viewPath);
            return ob_get_clean();
        }
    }

    /**
     * @param $view
     * @param $data
     */
    public function render($view, $data = null)
    {
        $rootDir = App::getConfig()['rootDir'];
        $content = $this->getViewContent($view, $data);

        if ($this->layout !== null) {
            $layoutPath = $rootDir . '/app/views/' . $this->layout . '.php';
            if (file_exists($layoutPath)) {
                require($layoutPath);
            }
        }
    }

    /**
     * @param $view
     * @param $data
     */
    public function renderPartial($view, $data = null)
    {
        $rootDir = App::getConfig()['rootDir'];
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'Database');
        } else {
            $data = $data;
        }
        $viewPath = $rootDir . '/app/views/' . $view . '.php';
        if (file_exists(($viewPath))) {
            require($viewPath);
        }
    }

    /**
     * @param $model
     */
    public function renderCT($model)
    {
        $rootDir = App::getConfig()['rootDir'];

        if ($this->layout !== null) {
            $modelPath = $rootDir . '/app/models/' . $model . '.php';
            if (file_exists($modelPath)) {
                require($modelPath);
            }
        }
    }
}