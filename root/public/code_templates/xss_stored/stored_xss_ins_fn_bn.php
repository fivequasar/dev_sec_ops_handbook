<?php

$server = $_POST["server_var"];
$username = $_POST["username_var"];
$password = $_POST["password_var"];
$db = $_POST["db_var"];

$conn = new mysqli($server, $username, $password, $db);

$message = $_POST['message'];

if (empty($message)) {

    echo "Empty messages are not allowed. Write Something!<br><br>";
    echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";

  } else{

$stmt = $conn->prepare("INSERT INTO comments (message) VALUES (?)");

$stmt->bind_param("s", $message);

if ($stmt->execute()) {
    echo "<p>Message Sent!</p>";
    echo "<button onclick='history.back()' style='padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;'>Go Back</button>";
}

$stmt->close();
$conn->close();


}


?>