<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$username = ""; //Assume this is $_GET["username"];

$password = ""; //Assume this is $_GET["password"];

$sql = "SELECT username FROM users WHERE username = '$username' AND password = '$password';";

try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception("Error executing query: " . $conn->error);

    } else {
        
        ?> 

                <?php
                        if ($result->num_rows > 0) { 
                                while($row = $result->fetch_assoc()) { 
                                echo "Welcome, " . $row["username"]. ". Login Successful!"; 
                                echo "<br>";
                                }
                        } else{
                            echo "Login Failed";
                            echo "<br>";
                        }
                        $conn->close();
                ?>
                <br>
                <button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>


        <?php

    }

} catch (Exception $e) {

    echo "Error: " . $e->getMessage();

    ?> 

    <br><br><button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

    <?php

    $conn->close();
}

?>