<?php

namespace app\controllers;

use app\core\Controller;

/*
 * HomeController extends Controller
 */

class HomeController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $this->render('index');
    }
}