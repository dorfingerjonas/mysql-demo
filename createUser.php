<?php
$_db_host = "localhost";
$_db_database = "web";
$_db_username = "web";
$_db_password = "web";

session_start();

$conn = new mysqli($_db_host,$_db_username,$_db_password,$_db_database);
if ($conn->connect_error){
    die("Connection failed, ". $conn->connect_error);
}

if (!empty($_POST['submit'])) {
    $_username = $conn->real_escape_string($_POST['username']);
    $_password = $conn->real_escape_string($_POST['password']);
    if (strcmp($_password, $conn->real_escape_string($_POST['password_2'])) != 0) {
        include("index.html");
        exit;
    }

    $_password = "saver". $_password;

    $insertStatement = "INSERT INTO login_username (username, password, user_deleted, last_login) VALUES ('$_username', md5('$_password'),0,NOW())";
    if ($res = $conn->query($insertStatement)) {
        echo "<br>User $_username has been added to the database. <br>Try to log in.";
        include("login.html");
    } else {
        echo "<br>No insertion. User could not be added. Maybe user $_username already exists.";
        include("index.html");
    }
} else {
    include("index.html");
}

$conn->close();
echo "end of php file";