<?php

namespace app\controllers;

use app\core\Controller;

/*
 * DashboardController extends Controller
 */

class DashboardController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        \Session::init();
        $logged = \Session::get('loggedIn');
        if ($logged == false) {
            \Session::destroy();
            header('location: login');
            exit;
        } else {
            $this->render('index');
        }
    }
}