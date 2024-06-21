<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}

$username = $_SESSION["username"];

$sql = "SELECT cart_$username.product_id, product_list.product_name, product_list.product_price, cart_$username.quantity, product_list.product_quantity FROM cart_$username INNER JOIN product_list ON cart_$username.product_id = product_list.product_id";
$result = mysqli_query($conn, $sql);

$isNotEnough = 0;

?>

<h1>Cart List</h1>

<?php

$totalPrice = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row["product_id"];
        $productName = $row["product_name"];
        $productPrice = $row["product_price"];
        $quantity = $row["quantity"];
        $productQuantity = $row["product_quantity"];

        if($quantity <= $productQuantity){
            echo "<li><p>Product name: $productName <br>
            Product price: RM $productPrice <br>
            Product quantity: $quantity <br></p>
            <form action='removeItemFromCart.php' method='get'>
                <button type='submit' name='itemRemove' value='$productId'>remove from cart</button>
            </form></li>";
        } else {
            $isNotEnough = 1;
            echo "<li><p>Product name: $productName <br>
            Product price: RM $productPrice <br>
            Product quantity: $quantity <br>
            ! THIS ITEM IS NOT ENOUGH STOCK !<br></p>
            <form action='removeItemFromCart.php' method='get'>
                <button type='submit' name='itemRemove' value='$productId'>remove from cart</button>
            </form></li>";
        }

        $totalPrice = $totalPrice + ($productPrice * $quantity);
    }
}
else {
    $isNotEnough = 1;
    echo "there is no item in cart yet";
}

echo "<h2>Total Price: RM $totalPrice</h2>";

if($isNotEnough == 1){
    echo "<button type='submit' disabled>Check Out</button>";
} else {
    echo "
    <form action='checkOut.php' method='post'>
        <label for='receiverName'>Receiver Name: </label>
        <input type='text' name='receiverName' required><br>
        <label for='receiverPhoneNumber'>Receiver Phone Number: </label>
        <input type='text' name='receiverPhoneNumber' required><br>
        <label for='receiverAddress'>Receiver Address: </label>
        <input type='text' name='receiverAddress' required><br>
        <button type='submit' name='checkOut' value='$isNotEnough'>Check Out</button>
    </form>
    ";
}

?>



