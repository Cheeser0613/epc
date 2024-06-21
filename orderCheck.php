<?php

session_start();
include("database.php");
include("header.php");

if(!isset($_SESSION["username"])){
    header("location:login.php");
}

$orderOwner = $_SESSION["username"];

if (isset($_GET["orderSearch"])) {
    $orderSearch = $_GET["orderSearch"];
    $sql = "SELECT * FROM order_list 
    WHERE order_owner = '$orderOwner' 
    AND (order_id LIKE '%$orderSearch%' 
    OR order_status LIKE '%$orderSearch%' 
    OR order_date LIKE '%$orderSearch%'
    OR receiver_name LIKE '%$orderSearch%' 
    OR receiver_phone_number LIKE '%$orderSearch%' 
    OR receiver_address LIKE '%$orderSearch%') 
    ORDER BY order_id DESC";
}
else {
    $sql = "SELECT * FROM order_list WHERE order_owner = '$orderOwner' ORDER BY order_id DESC";
}

?>

<body>  
    <form method="get">
        <input type="text" name="productSearch" placeholder="leave empty to list all">
        <button type="submit">Search</button>
    </form>

<?php

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    echo "<table>
    <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Order Owner</th>
        <th>Receiver Name</th>
        <th>Receiver Phone Number</th>
        <th>Receiver Address</th>
        <th>Order Status</th>
    </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $orderId = $row["order_id"];
        $orderOwner = $row["order_owner"];
        $orderStatus = $row["order_status"];
        $orderDate = $row["order_date"];
        $receiverName = $row["receiver_name"];
        $receiverPhoneNumber = $row["receiver_phone_number"];
        $receiverAddress = $row["receiver_address"];

        echo "<tr>
                <td><a href='orderContentPreview.php?orderId=$orderId'>$orderId</a><td>
                <td>$orderDate<td>
                <td>$orderOwner<td>
                <td>$receiverName<td>
                <td>$receiverPhoneNumber<td>
                <td>$receiverAddress<td>
                <td>$orderStatus</td>
            </tr>";
    }

    echo "</table>";

}
else {
    echo "there is no order yet";
}

?>