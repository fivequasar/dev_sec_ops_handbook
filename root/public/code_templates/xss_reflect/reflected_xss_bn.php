<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$name =  ""; //Assume that this is $_GET["name"];

$sql = "SELECT id, name, country FROM products WHERE name LIKE '$name'";

try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception($conn->error);

    } else {
        
        ?> 

            <h1>Results:</h1>

                <?php
                        if ($result->num_rows > 0) { 
                                while($row = $result->fetch_assoc()) { 
                                echo "ID: " . $row["id"]. " Name: " . $row["name"]. " Country: " . $row["country"]. "<br>"; 
                                }
                        } else{
                            echo "0 results for $name";
                        }
                        $conn->close();
                ?>
                <br>
                <button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

        <?php

    }

} catch (Exception $e) {

    echo 'Error: ' .$e->getMessage();

    ?> 

    <br><br><button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

    <?php

    $conn->close();
} 

?>