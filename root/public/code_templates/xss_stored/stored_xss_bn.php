<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$sql = "SELECT id, message FROM comments;";

$result = $conn->query($sql);

if ($result->num_rows > 0) { 

    while($row = $result->fetch_assoc()) { 

    echo "Message ". $row["id"] . ", " . $row["message"]. "!"; 
    echo "<br>";

    }

    echo "<br>";
    echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";
                                
    } 
    
    $conn->close();


?>