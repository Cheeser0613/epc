<?php

session_start();
include("database.php");
include("header.php");

if((!isset($_SESSION["username"])) or ($_SESSION["role"] !== "admin")){
    header("location:login.php");
}

if(isset($_POST["submit"])){
    $productImage = "productImages/".$_FILES["productImage"]["name"];
    $productImageTmp = $_FILES["productImage"]["tmp_name"];
    $productName = $_POST["productName"];
    $productPrice = $_POST["productPrice"];
    $productQuantity = $_POST["productQuantity"];

    $sql = "SELECT * FROM product_list WHERE product_image = '$productImage'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(is_array($row)){
        echo "the image file name is used, please rename the image file name";
    } else {
        if(!file_exists($productImageTmp) or !is_uploaded_file($productImageTmp)) {
            $productImage = "productImages/null.png";
        } else {
            move_uploaded_file($productImageTmp, $productImage);
        }
        
        $sql = "INSERT INTO product_list (product_name, product_price, product_image, product_quantity) VALUES ('$productName','$productPrice','$productImage', '$productQuantity')";
        
        if(mysqli_query($conn, $sql)){
            echo "product ".$productName." added into the system";
        } else {
            echo "fail to add product ".$productName;
        }
    }
}

?>


<form method="post" enctype="multipart/form-data">
    <label>product image:</label>
    <input type="file" name="productImage">
    <label>product name:</label>
    <input type="text" name="productName" required>
    <label>product price:</label>
    <input type="text" name="productPrice" required>
    <label>product quantity:</label>
    <input type="text" name="productQuantity" required>
    <input type="submit" name="submit" value="add">
</form>