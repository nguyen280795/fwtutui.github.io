<?php

$pdo = new PDO('mysql:host=localhost;dbname=myframework', 'root', '');

$query1 = "INSERT INTO users (login, password) VALUES ('nguyen', MD5('nguyen'))";
$query2 = "INSERT INTO data (id, text) VALUES ('a', 'b'";

$db->beginTransaction();

$kq1 = $db->exec($query1);
$kq2 = $db->exec($query2);

if (!$kq1 || !$kq2) {
    $db->rollBack();
    echo 'Fail!';
} else {
    $db->commit();
    echo 'Success!';
}
