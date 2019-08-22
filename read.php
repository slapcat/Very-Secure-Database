<html>
<head>
<title>
VSDb Client
</title>
<tt>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid black;
    text-align: left;
    padding: 8px;
}
</style>
</head>
<?php
session_start();
$key = $_SESSION['keys'];

if ($key == "") {
$key = $_POST["key"];
$_SESSION['keys'] = $key;
}

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
	}
}
}  else {
	  error_log("Error: " . $sql);
}

echo '<form name="add" action="add.php" method="POST" enctype="multipart/form-data"><label for="name">Name: </label><input name="name" id="name" type="text" class="formbox" /><BR><label for="pic">Picture: </label><input type="file" name="pic" id="pic"><BR><label for="add">Address: </label><input name="add" id="add" type="text" class="formbox" /><BR><label for="con">Contact Number/Email: </label><input name="con" id="con" type="text" class="formbox" /><BR><label for="link">Social Media URL: </label><input name="link" id="link" type="text" class="formbox" /><BR><label for="rel">Relatives: </label><input name="rel" id="rel" type="text" class="formbox" /><BR><label for="gen">General Comments: </label><input name="gen" id="gen" type="text" class="formbox" /><BR><input name="submit" id="submit" type="submit" value="add" /><BR><BR></form>';

$sql = "SELECT * FROM data ORDER BY ID DESC";
$result = $conn->query($sql);

echo '<table><tr><th>Full Name</th><th>Picture</th><th>Address</th><th>Contact Number/Email</th><th>Social Media</th><th>Relatives</th><th>General Comments</th></tr>';

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())  {
	$iv = "3450691827364523";
	$n_de = openssl_decrypt($row["N"], "aes-128-cbc", $key, 0, $iv);
	$p_de = openssl_decrypt($row["P"], "aes-128-cbc", $key, 0, $iv);
	$a_de = openssl_decrypt($row["A"], "aes-128-cbc", $key, 0, $iv);
	$c_de = openssl_decrypt($row["C"], "aes-128-cbc", $key, 0, $iv);
	$s_de = openssl_decrypt($row["S"], "aes-128-cbc", $key, 0, $iv);
	$r_de = openssl_decrypt($row["R"], "aes-128-cbc", $key, 0, $iv);
	$g_de = openssl_decrypt($row["G"], "aes-128-cbc", $key, 0, $iv);

	/*if ($p_de == "") {
	$p_code = "";
	} else {

	}
	for unlinking not existent images
	*/

	if ($n_de != "") {
	print_r('<tr><td>' . $n_de . '</td><td><a href="img/' . $p_de . '"><img src="img/' . $p_de . '" height="100" width="100"></a></td><td>' . $a_de . '</td><td>' . $c_de . '</td><td><a href="' . $s_de . '">' . $s_de . '</a></td><td>' . $r_de . '</td><td>' . $g_de . '</td></tr>');
	

	}
}
	echo '</table>';
}  else {
	  error_log("Error: " . $sql);
}

$conn->close();



?>

</tt>
</html>
