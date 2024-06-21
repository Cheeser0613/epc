<?php

session_start();
include("database.php");
include("header.php");

if((!isset($_SESSION["username"])) or ($_SESSION["role"] !== "admin")){
    header("location:login.php");
}

?>

<h1>Admin Menu</h1>
<a href="productManage.php">Manage Product</a><br>
<a href="orderManage.php">Manage Order</a>