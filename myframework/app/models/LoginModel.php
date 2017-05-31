<?php

/*
 * LoginModel extends Model
 */

class LoginModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $sth = $this->db->prepare("SELECT id FROM users WHERE login = :login AND password = MD5(:password)");
        $sth->execute(array(
            ':login' => $_POST['username'],
            ':password' => $_POST['password']
        ));

        $count = $sth->rowCount();
        if ($count > 0) {
            \Session::init();
            \Session::set('loggedIn', true);
            header('location: ../dashboard');
        } else {
            header('location: ../login');
        }
    }

    public function logout()
    {
        \Session::init();
        \Session::destroy();
        header('location: login');
    }

}