<?php

namespace app\controllers;

use app\core\Controller;

/*
 * AboutController extends Controller
 */

class AboutController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('index');
    }
}