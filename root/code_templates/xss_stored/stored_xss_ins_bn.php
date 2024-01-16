<?php
$server = 'localhost';
$username = 'sandbox_user';
$password = 'password';
$db = 'sample_db';

$conn = new mysqli($server, $username, $password, $db);
$message = '';

if (isset($_POST['message'])) {
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO comments (message) VALUES (?)");
    $stmt->bind_param("s", $message);

    if (!$stmt->execute()) {
        throw new Exception("Error executing query: " . $stmt->error);
    }

    echo "<p>Message Sent!</p>";
    echo "<button onclick=\"history.back()\" style=\"padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;\">Go Back</button>";

    $stmt->close();
    $conn->close();
}
?>