<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$username = "administrator"; //Assume that this is $_GET["username"];

$password = "password"; //Assume that this is $_GET["password"];

$stmt = $conn->prepare("SELECT username FROM users WHERE username = ? AND password = ?");

$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {     
	while($row = $result->fetch_assoc()) {   
		echo "Welcome, " . $row["username"]. ". Login Successful!";   
	}
} else {  
	echo "Login Failed";     
}      

$conn->close();
?>