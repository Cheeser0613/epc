<?php

session_start();
include("database.php");
include("header.php");

if((!isset($_SESSION["username"])) or ($_SESSION["role"] !== "admin")){
    header("location:login.php");
}

if(isset($_POST["statusUpdate"])){
    $orderId = $_POST["statusUpdate"];
    $orderStatus = $_POST["orderStatus"];

    $sql = "UPDATE order_list SET order_status = '$orderStatus' WHERE order_id = '$orderId'";
    if(mysqli_query($conn, $sql)){
        echo "status of order ".$orderId." updated";
    } else {
        echo "fail to update order ".$orderId;
    }   
}

if (isset($_GET["orderSearch"])) {
    $orderSearch = $_GET["orderSearch"];
    $sql = "SELECT * FROM order_list 
    WHERE order_owner LIKE '%$orderSearch%' 
    OR order_id LIKE '%$orderSearch%' 
    OR order_status LIKE '%$orderSearch%' 
    OR order_date LIKE '%$orderSearch%'
    OR receiver_name LIKE '%$orderSearch%' 
    OR receiver_phone_number LIKE '%$orderSearch%' 
    OR receiver_address LIKE '%$orderSearch%' 
    ORDER BY order_id DESC";
}
else {
    $sql = "SELECT * FROM order_list ORDER BY order_id DESC";
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
                <td><form method='post'>
                        <select name='orderStatus'>
                            <option value='$orderStatus' selected>$orderStatus</option>
                            <option value='pending'>pending</option>
                            <option value='sent'>sent</option>
                            <option value='canceled'>canceled</option>
                        </select>
                        <button type='submit' name='statusUpdate' value='$orderId'>update status</button>
                    </form></td>
            </tr>";
    }

    echo "</table>";

}
else {
    echo "there is no order yet";
}

?>

