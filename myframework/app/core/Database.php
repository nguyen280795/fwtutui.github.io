<?php

/*
 * Database
 */

class Database extends PDO
{
    public function __construct($type, $host, $name, $user, $pass)
    {
        parent::__construct($type . ':host=' . $host . ';dbname=' . $name, $user, $pass);
    }
}