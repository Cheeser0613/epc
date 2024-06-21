<?php

session_start();
include("database.php");

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM account WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $hashedPassword = $row["hashed_password"];

    if(is_array($row) and password_verify($password, $hashedPassword)){
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
    } else {
        echo "username or password was wrong";
    }
}

if(isset($_SESSION["role"])){
    if($_SESSION["role"] == "admin"){
        header("location:home.php");
    } elseif($_SESSION["role"] == "user") {
        header("location:home.php");
    }
}

?>

<body>

    <form method="post">
        <label for="username">username:</label>
        <input type="text" name="username" required>
        <label for="password">password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="submit" value="login">
    </form>

    <a href="register.php">register</a>

</body>