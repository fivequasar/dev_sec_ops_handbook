<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$message = "";

if (empty($message)) {

    echo "Empty messages are not allowed. Write Something!<br><br>";
    echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";

} else{

  if (preg_match('/^[a-zA-Z]+$/', $message)) {

    $stmt = $conn->prepare("INSERT INTO comments (message) VALUES (?)");

    $stmt->bind_param("s", $message);
    
    if ($stmt->execute()) {
        echo "<p>Message Sent!</p>";
        echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";
    }
    
    $stmt->close();
    $conn->close();

  } else {

    echo "<p>Invalid Input</p>";
    echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";

  }

}


?>