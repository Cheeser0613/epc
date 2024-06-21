<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}


if (isset($_GET["productSearch"])) {
    $productSearch = $_GET["productSearch"];
    $sql = "SELECT * FROM product_list WHERE product_name LIKE '%$productSearch%' OR product_id LIKE '%$productSearch%'";
}
else {
    $sql = "SELECT * FROM product_list WHERE product_quantity<>'0'";
}

?>

<body>
    <h1>Product List</h1>  
    <form method="get">
        <input type="text" name="productSearch" placeholder="leave empty to list all">
        <button type="submit">Search</button>
    </form>

    <?php
    
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productImage = $row["product_image"];
            $productId = $row["product_id"];
            $productName = $row["product_name"];
            $productPrice = $row["product_price"];
            $productQuantity = $row["product_quantity"];
            
            if($productQuantity == 0){
                echo "<li><img src='$productImage' alt='product image' width='200px' height='200px'>
                <p>Product ID: $productId <br>
                Product name: $productName <br>
                Product price: RM $productPrice <br>
                Product quantity: $productQuantity <br></p>
                <button type='submit' disabled>out of stock</button></li>";
            } else {
                echo "<li><img src='$productImage' alt='product image' width='200px' height='200px'>
                <p>Product ID: $productId <br>
                Product name: $productName <br>
                Product price: RM $productPrice <br>
                Product quantity: $productQuantity <br></p>
                <form action='addItemToCart.php' method='get'>
                    <button type='submit' name='itemAdd' value='$productId'>add to cart</button>
                </form></li>";
            }
        }
    }
    else {
        echo "there is no product yet";
    }

    ?>

</body>

