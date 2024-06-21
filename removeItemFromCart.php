<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}

if(isset($_GET["itemRemove"])){
    $productId = $_GET["itemRemove"];
    $username = $_SESSION["username"];

    $sql = "SELECT * FROM cart_$username WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(is_array($row)){
        $sql = "DELETE FROM cart_$username WHERE product_id = '$productId'";
    } else {
        echo "item doesn't exist in cart";
    }

    if(mysqli_query($conn, $sql)){
        echo "item removed from cart";
    } else {
        echo "fail to update cart";
    }
}

?>

<a href="home.php">back to home page</a>
<a href="cart.php">check cart</a>