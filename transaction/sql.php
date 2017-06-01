<?php
$con = mysqli_connect("localhost", "root", "", "myframework");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Set autocommit to off
mysqli_autocommit($con, FALSE);

// Insert some values
$kq1 = mysqli_query($con, "INSERT INTO users (login, password) VALUES ('nguyen', MD5('nguyen'))");
$kq2 = mysqli_query($con, "INSERT INTO data (id, text) VALUES ('a', 'b'");

if (!$kq1 || !$kq2) {
    mysqli_rollback($con);
    echo 'Fail!';
} else {
    mysqli_commit($con);
    echo 'Success!';
}

// Commit transaction
//mysqli_commit($con);
//mysqli_rollback($con);

// Close connection
mysqli_close($con);