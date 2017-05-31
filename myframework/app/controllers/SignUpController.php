<?php

namespace app\controllers;

use app\core\Controller;

require_once(dirname(__DIR__) . '/models/SignUpModel.php');

/*
 * AboutController extends Controller
 */

class SignUpController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('index');
    }

    public function run()
    {
        $md=new \SignUpModel();
        $md->run();
    }
}