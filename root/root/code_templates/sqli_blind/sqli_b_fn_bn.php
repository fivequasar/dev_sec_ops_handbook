<?php

$server = $_GET["server_var"];
$username = $_GET["username_var"];
$password = $_GET["password_var"];
$db = $_GET["db_var"];

$conn = new mysqli($server, $username, $password, $db);

$id = $_GET["id"]; 

$sql = "SELECT id, name, country FROM products WHERE id = $id;";

try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception("Error executing query: " . $conn->error);

    } else {
        
        ?> 

            <h1>Results:</h1>

                <?php
                        if ($result->num_rows > 0) { 
                                while($row = $result->fetch_assoc()) { 
                                echo "ID: " . $row["id"]. " Name: " . $row["name"]. " Country: " . $row["country"]. "<br>"; 
                                }
                        } else{
                            echo "0 results";
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