<html>
<title>
VSDb Client
</title>
<body><center><tt>
<BR><BR>
<img src="head.png">
<BR><BR><BR><BR><BR>
<form name="input" action="keymaker.php" method="POST">
<label for="key2">KEY: </label><input name="key2" id="key2" type="password" class="formbox" />
<input name="submit" id="submit" type="submit" value="go" /></form>
</tt></center></body>
</html>

<?php

$key = $_POST['key2'];
$iv = "3450691827364523";
$text = openssl_encrypt("new_key", "aes-128-cbc", $key, 0, $iv);

echo $text . "<BR>";

$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM ver";
$result = $conn->query($sql); 

if ($result->num_rows > 0) {	
	while($row = $result->fetch_assoc())  {
	$iv = "3450691827364523";
	$key_check = openssl_decrypt($row["A"], "aes-128-cbc", $key, 0, $iv);
	if ($key_check == "") {
	echo '<center><BR><BR>No, that is not the key.<BR><BR><img src="no.gif"><BR><BR><B>Please contact the system administrator if you think this was an error.</B></center>';
	$conn->close();
	die();
	} else {
	$_SESSION['burned'] = "no";
	echo $key_check;
	}
}
}  else {
	  error_log("Error: " . $sql);
}

$conn->close();

?>