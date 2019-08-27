<html>
<title>
VSDb Client
</title>
<body><center><tt>
<BR><BR>
<img src="head.png">
<BR><BR><BR>

<?php
$user = $_POST["user"];
$pass = $_POST["pass"];
$db = $_POST["db"];
$key = $_POST["key"];
$key2 = $_POST["key2"];

if (empty($user) && empty($pass) && empty($db) && empty($key) && empty($key2)) {
	show_form();
} elseif (empty($user) || empty($pass) || empty($db)) {
	echo '<b><font color="red">ERROR: Please enter your SQL information!</b></font><BR><BR>';
	show_form();
} elseif (empty($key)) {
	echo '<b><font color="red">ERROR: Key can not be blank!</b></font><BR><BR>';
	show_form();
} elseif ($key != $key2) {
	echo '<b><font color="red">ERROR: Keys do not match!</b></font><BR><BR>';
	show_form();
} else {
	
// GENERATE PHP FILES
if (!copy("read_template.php", "read.php")) {
    echo "FAILED TO COPY READ.PHP...<BR>";
} else {
echo "COPIED READ.PHP...<BR>";
}
if (!copy("add_template.php", "add.php")) {
    echo "FAILED TO COPY ADD.PHP...<BR>";
} else {
echo "COPIED ADD.PHP...<BR>";
}
chmod("read.php", 0660);
chmod("add.php", 0660);

// CREATE IMG DIRECTORY
if (!file_exists('img')) {
    mkdir('img', 0664, true);
    echo "DIRECTORY CREATED...<BR>";
} else {
echo "DIRECTORY EXISTS...<BR>";
}

// CREATE DATABASES
$conn = new mysqli("localhost", $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE DATABASE " . $db;
if ($conn->query($sql) === TRUE) {
	echo "DATABASE CREATED...<BR>";
} else {
    echo "Error creating database: " . $conn->error;
    die();
}

$conn->close();


$conn = new mysqli("localhost", $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE TABLE data (
ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
N TEXT,
P TEXT,
A TEXT,
C TEXT,
S TEXT,
R TEXT,
G TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "DATA TABLE CREATED...<BR>";
} else {
    echo "Error creating table: " . $conn->error;
    die();
}

$sql = "CREATE TABLE ver (A VARCHAR(100))";

if ($conn->query($sql) === TRUE) {
    echo "KEY TABLE CREATED...<BR>";
} else {
    echo "Error creating table: " . $conn->error;
    die();
}


// ADD KEY

$iv = "3450691827364523";
$key_en = openssl_encrypt("new_key", "aes-128-cbc", $key, 0, $iv);

$sql = "INSERT INTO ver (A)
VALUES ('$key_en')";

if ($conn->query($sql) === TRUE) {
	echo "KEY ADDED...<BR>";
} else {
    echo "Error adding key: " . $sql . "<br>" . $conn->error;
    die();
}

$conn->close();

// CONFIGURE PHP FILES
$read_php = file_get_contents('read.php');
	$read_php = str_replace("##USERNAME##", $user, $read_php);
	$read_php = str_replace("##PASSWORD##", $pass, $read_php);
	$read_php = str_replace("##DATABASE##", $db, $read_php);
file_put_contents('read.php', $read_php);

$add_php = file_get_contents('add.php');
	$add_php = str_replace("##USERNAME##", $user, $add_php);
	$add_php = str_replace("##PASSWORD##", $pass, $add_php);
	$add_php = str_replace("##DATABASE##", $db, $add_php);
file_put_contents('add.php', $add_php);

echo "<BR>SUCCESS!<BR><BR>";

// REDIRECT
echo '<a href="index.html">CLICK HERE TO LOGIN</a>';

// ERASE THE EVIDENCE
unlink("read_template.php");
unlink("add_template.php");
unlink(__FILE__);

}



function show_form() {
printf('<form name="input" action="install.php" method="POST">
<b>INSTALLATION SCRIPT</b><BR><BR>
<label for="user">SQL Username:</label><BR><input name="user" id="user" type="text" class="formbox" /><BR><BR>
<label for="pass">SQL Password:</label><BR><input name="pass" id="pass" type="password" class="formbox" /><BR><BR>
<label for="db">New Database Name:</label><BR><input name="db" id="db" type="text" class="formbox" /><BR><BR>
<label for="key">Key:</label><BR><input name="key" id="key" type="password" class="formbox" /><BR><BR>
<label for="key2">Retype Key:</label><BR><input name="key2" id="key2" type="password" class="formbox" /><BR><BR>
<input name="submit" id="submit" type="submit" value="INSTALL" /></form>
</tt></center></body>
</html>');
die();
}

?>