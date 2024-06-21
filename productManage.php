<?php

session_start();
include("database.php");
include("header.php");

if((!isset($_SESSION["username"])) or ($_SESSION["role"] !== "admin")){
    header("location:login.php");
}

?>

<form method="get">
    <input type="text" name="productSearch" placeholder="leave empty to list all">
    <button type="submit">Search</button>
</form>
<a href="addProduct.php">add product</a>

<?php

if (isset($_GET["productSearch"])) {
    $productSearch = $_GET["productSearch"];
    $sql = "SELECT * FROM product_list WHERE product_name LIKE '%$productSearch%' OR product_id LIKE '%$productSearch%'";
}
else {
    $sql = "SELECT * FROM product_list";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productImage = $row["product_image"];
        $productId = $row["product_id"];
        $productName = $row["product_name"];
        $productPrice = $row["product_price"];
        $productQuantity = $row["product_quantity"];
        echo "<li><img src='$productImage' alt='product image' width='200px' height='200px'>
            <p>Product ID: $productId <br>
            Product name: $productName <br>
            Product price: RM $$productPrice <br>
            Product quantity: $productQuantity <br></p>
            <a href='editProduct.php?productId=$productId'>edit</a></li>";
    }
}
else {
    echo "there is no product yet";
}

?>