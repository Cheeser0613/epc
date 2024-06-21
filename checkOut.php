<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if($_POST["checkOut"] == 0){
        $orderOwner = $_SESSION["username"];
        $orderStatus = "pending";
        $orderDate = date("ymd");
        $receiverName = $_POST["receiverName"];
        $receiverPhoneNumber = $_POST["receiverPhoneNumber"];
        $receiverAddress = $_POST["receiverAddress"];

        $createOrder = "INSERT INTO order_list (order_owner, order_status, order_date, receiver_name, receiver_phone_number, receiver_address)
                        VALUES ('$orderOwner', '$orderStatus', '$orderDate', '$receiverName', '$receiverPhoneNumber', '$receiverAddress')";

        mysqli_query($conn, $createOrder);

        $sql = "SELECT MAX(order_id) AS last_order_id FROM order_list";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $lastOrderId = $row["last_order_id"];

        $OrderContentTableCreate = "CREATE TABLE order_$lastOrderId (product_id INT(10) NOT NULL, quantity INT(10) NOT NULL, purchase_price INT(10) NOT NULL, FOREIGN KEY (product_id) REFERENCES product_list(product_id))";
        mysqli_query($conn, $OrderContentTableCreate);

        $fromSql = "SELECT * FROM cart_$orderOwner";
        $fromResult = mysqli_query($conn, $fromSql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($fromResult)){
                $productId = $row["product_id"];
                $quantity = $row["quantity"];

                $productQuantityAndPriceSql = "SELECT product_quantity, product_price FROM product_list WHERE product_id = '$productId'";
                $productQuantityAndPriceResult = mysqli_query($conn, $productQuantityAndPriceSql);
                $productQuantityAndPriceRow = mysqli_fetch_assoc($productQuantityAndPriceResult);
                $productQuantity = $productQuantityAndPriceRow["product_quantity"] - $quantity;
                $productPrice = $productQuantityAndPriceRow["product_price"];

                $updateProductQuantity = "UPDATE product_list SET product_quantity = '$productQuantity' WHERE product_id = '$productId'";
                mysqli_query($conn, $updateProductQuantity);

                $toSql = "INSERT INTO order_$lastOrderId VALUES ('$productId', '$quantity', '$productPrice')";
                mysqli_query($conn, $toSql);
            }
            $clearCart = "DELETE FROM cart_$orderOwner";
            mysqli_query($conn, $clearCart);
            echo "check out successful";

        } else {
            echo "There is nothing in cart";
        }
        
    } else {
        echo "fail to check out";
    }
}
?>