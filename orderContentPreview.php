<?php

session_start();
include("database.php");
include("header.php");

$orderId = $_GET["orderId"];
$sql = "SELECT order_owner, order_date FROM order_list WHERE order_id = '$orderId'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$orderOwner = $row["order_owner"];
$orderDate = $row["order_date"];

if((!isset($_SESSION["username"])) or !(($_SESSION["role"] !== "admin") or ($_SESSION["username"] !== "$orderOwner"))){
    header("location:login.php");
}

echo "<h1>purchase by " . $orderOwner . " on " . $orderDate . "</h1><br>";

$sql = "SELECT order_$orderId.product_id, product_list.product_name, order_$orderId.purchase_price, order_$orderId.quantity FROM order_$orderId INNER JOIN product_list ON order_$orderId.product_id = product_list.product_id";
$result = mysqli_query($conn, $sql);

$totalPrice = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row["product_id"];
        $productName = $row["product_name"];
        $productPrice = $row["purchase_price"];
        $productQuantity = $row["quantity"];

        echo "<li><p>Product ID: $productId <br>
                Product name: $productName <br>
                Product price: RM $productPrice <br>
                Product quantity: $productQuantity <br></p></li>";
        
        $totalPrice = $totalPrice + ($productPrice * $productQuantity);
    }
    echo "<h2>Total Price : RM $totalPrice</h2>";
} else {
    echo "This order is empty";
}

?>