<?php

$servername = 'localhost';
$username = 'sandbox_user';
$password = 'password';
$dbname = 'sample_db';

$conn = new mysqli($servername, $username, $password, $dbname);


$id = "1";

//Error-Based SQL Injection
//$id = "'";

//Union-Based SQL Injection.
//$id = "1 UNION SELECT id, name, address FROM hidden_table";

//Boolean-Based (Blind) SQL Injection
//$id = "1 AND 1 = 1";

//Time-Based SQL Injection
//$id = "1 AND IF(1=1, SLEEP(5), SLEEP(0))";

$sql = "SELECT id, name, address FROM sample_table WHERE id = $id;";

$result = $conn->query($sql);



try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception("Error executing query: " . $conn->error);

    } else {
        
        ?> 

        <body>

            <h1 >Results:</h1>

                <?php
                        if ($result->num_rows > 0) { 
                                while($row = $result->fetch_assoc()) { 
                                echo "<div id='output-container'>";
                                echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Address: " . $row["address"]. "<br>"; 
                                echo "</div>";
                                }
                                $conn->close();
                        } else{
                            echo "<div id='output-container'>";
                            echo "0 results";
                            echo "</div>";
                            $conn->close();
                        }
                        
                ?>

        </body>

        <?php

    }

} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
    $conn->close();
}

?>