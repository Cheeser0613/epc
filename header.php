<p>welcome <?php echo $_SESSION['username'];?></p>
<ul>
    <li><a href="home.php">home</a></li>
    <li><a href="cart.php">cart</a></li>
    <li><a href="orderCheck.php">order</a></li>
    <li><a href = "logout.php">logout</a></li>   
    <?php
    if($_SESSION["role"] == "admin"){
        echo "<li><a href='admin.php'>admin</a></li>";
    }
    ?>
</ul>