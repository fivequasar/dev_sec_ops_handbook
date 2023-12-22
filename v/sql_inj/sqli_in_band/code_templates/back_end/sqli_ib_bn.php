<?php

$server = 'localhost';
$username = 'sandbox_user';
$password = 'password';
$db = 'sample_db';

$conn = new mysqli($server, $username, $password, $db);

$username = $_POST["username"];

$password = $_POST["password"];

$sql = "SELECT id, username, message FROM users WHERE username = '$username' AND password = '$password';";

try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception("Error executing query: " . $conn->error);

    } else {
        
        ?> 



            <h1 >Results:</h1>

                <?php
                        if ($result->num_rows > 0) { 
                                while($row = $result->fetch_assoc()) { 
                                echo "Today's Message: " . $row["message"] . "<br>"; 
                                }
                        } else{
                            echo "0 results";
                        }
                        $conn->close();
                ?>
                <br>

        <?php

    }

} catch (Exception $e) {

    echo "Error: " . $e->getMessage();

    $conn->close();
}

?>