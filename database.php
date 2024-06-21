<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db = 'epc';

$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
    die("connection fail: " . mysqli_connect_error());
}

?>