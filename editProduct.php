<?php

session_start();
include("database.php");
include("header.php");

if((!isset($_SESSION["username"])) or ($_SESSION["role"] !== "admin")){
    header("location:login.php");
}

$productId = $_GET["productId"];

$sql = "SELECT * FROM product_list WHERE product_id = '$productId'";
$result = mysqli_query($conn, $sql);
$value = mysqli_fetch_assoc($result);

$productName = $value["product_name"];
$productPrice = $value["product_price"];
$productQuantity = $value["product_quantity"];

if(isset($_POST["submit"])){
    $productName = $_POST["productName"];
    $productPrice = $_POST["productPrice"];
    $productQuantity = $_POST["productQuantity"];

    $sql = "UPDATE product_list SET product_name = '$productName', product_price = '$productPrice', product_quantity = '$productQuantity' WHERE product_id = '$productId'";
    if(mysqli_query($conn, $sql)){
        echo "product ".$productName." updated";
    } else {
        echo "fail to update product ".$productName;
    }   
}

?>

<form method="post">
    <label>product name:</label>
    <input type="text" name="productName" value="<?php echo $productName?>" required>
    <label>product price:</label>
    <input type="text" name="productPrice" value="<?php echo $productPrice?>" required>
    <label>product quantity:</label>
    <input type="text" name="productQuantity" value="<?php echo $productQuantity?>" required>
    <input type="submit" name="submit" value="edit">
</form>