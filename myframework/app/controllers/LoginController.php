<?php

namespace app\controllers;

use app\core\Controller;

require_once(dirname(__DIR__) . '/models/LoginModel.php');

/*
 * LoginController extends Controller
 */

class LoginController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        \Session::init();
        $logged = \Session::get('loggedIn');
        if ($logged == true) {
            header('location: dashboard');
            exit;
        } else {
            $this->render('index');
        }
    }

    public function server()
    {
        $md = new \LoginModel();
        $md->run();
    }

    public function logout()
    {
        $md = new \LoginModel();
        $md->logout();
    }
}