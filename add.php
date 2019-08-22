<?php
session_start();
$name = $_POST["name"];
$link = $_POST["link"];
$con = $_POST['con'];
$add = $_POST['add'];
$rel = $_POST['rel'];
$gen = $_POST['gen'];
$key = $_SESSION['keys'];

if ($_SESSION['burned'] == "") {
	header('Location: http://homepage.com');
	die();
}
/*
if ($name == "") {
	echo "<script type='text/javascript'>alert('Who are you talking about? We need to know the name at least.')</script>";
	header('Location: http://homepage.com/read.php');
	die();
}*/

a:
$pic = rand(1, 10000);
$destination = "img/" . $pic;
if (file_exists($destination)) {
goto a;
}

$iv = "3450691827364523";
$name_en = openssl_encrypt($name, "aes-128-cbc", $key, 0, $iv);
$link_en = openssl_encrypt($link, "aes-128-cbc", $key, 0, $iv);
$pic_en = openssl_encrypt($pic, "aes-128-cbc", $key, 0, $iv);
$con_en = openssl_encrypt($con, "aes-128-cbc", $key, 0, $iv);
$add_en = openssl_encrypt($add, "aes-128-cbc", $key, 0, $iv);
$rel_en = openssl_encrypt($rel, "aes-128-cbc", $key, 0, $iv);
$gen_en = openssl_encrypt($gen, "aes-128-cbc", $key, 0, $iv);

if (move_uploaded_file($_FILES["pic"]["tmp_name"], $destination)) {
	error_log("file uploaded");
    } else {
        error_log("File not uploaded");
    }

$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO data (N, P, A, C, S, R, G)
VALUES ('$name_en', '$pic_en', '$add_en', '$con_en', '$link_en', '$rel_en', '$gen_en')";

if ($conn->query($sql) === TRUE) {
	header('Location: http://homepage.com/read.php');
	die();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();


?>
