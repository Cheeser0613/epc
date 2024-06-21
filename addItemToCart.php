<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}

if(isset($_GET["itemAdd"])){
    $productId = $_GET["itemAdd"];
    $username = $_SESSION["username"];

    $sql = "SELECT * FROM cart_$username WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(is_array($row)){
        $quantity = $row["quantity"] + 1;
        $sql = "UPDATE cart_$username SET quantity = $quantity WHERE product_id = '$productId'";
    } else {
        $sql = "INSERT INTO cart_$username VALUES ('$productId', '1')";
    }

    if(mysqli_query($conn, $sql)){
        echo "item added to cart";
    } else {
        echo "fail to update cart";
    }
}

?>

<a href="home.php">back to home page</a>
<a href="cart.php">check cart</a>