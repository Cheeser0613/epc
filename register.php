<?php

include("database.php");

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM account WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(is_array($row)){
        echo "this username have been used";
    } else {
        $sql = "INSERT INTO account VALUES ('$username','$password','user')";
        $addCart = "CREATE TABLE cart_$username (product_id INT(10) NOT NULL, quantity INT(10) NOT NULL, FOREIGN KEY (product_id) REFERENCES product_list(product_id))";
        if (mysqli_query($conn, $sql) and mysqli_query($conn, $addCart)) {
            echo "Account successfully registered";
        }
        else {
            echo "fail to add: " . mysqli_error($conn);
        }
    }
}

?>

<body>

    <form method="post">
        <label for="username">username:</label>
        <input type="text" name="username" required>
        <label for="password">password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="submit" value="register">
    </form>

    <a href="login.php">already have an account</a>

</body>