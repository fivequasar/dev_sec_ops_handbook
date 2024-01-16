<?php

$server = $_GET["server_var"];
$username = $_GET["username_var"];
$password = $_GET["password_var"];
$db = $_GET["db_var"];

$conn = new mysqli($server, $username, $password, $db);

$username = $_GET["username"]; 

$password = $_GET["password"];

$usernameCount = 0;

$passwordCount = 0;

if (preg_match('/^[a-zA-Z]{8,13}$/', $username) == 1 && preg_match('/^[a-zA-Z]{8,13}$/', $username) == 1) {

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
    
    } else {
    
        echo "Login Failed";
        
    }

$conn->close();
?>