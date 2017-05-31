<?php

/*
 * SignUpModel extends Model
 */

class SignUpModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = sprintf("INSERT INTO users (login, password) VALUES ('$username',MD5('$password'))");
        $query1 = sprintf("SELECT login FROM users where login like :login");

        $this->db->beginTransaction();
        $kq = $this->db->exec($query);


        $sth = $this->db->prepare($query1);
        $sth->execute(array(
            ':login' => $username,
        ));

        $count = $sth->rowCount();

        if (!$kq || $count > 1) {
            $this->db->rollBack();
            header('location: signup');
        } else {
            $this->db->commit();
            header('location: login');
        }
    }
}