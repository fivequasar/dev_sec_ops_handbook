<?php

$servername = 'localhost';
$username = 'sandbox_user';
$password = 'password';
$db = 'sample_db';

$conn = new mysqli($servername, $username, $password, $db);

$id = $_POST["id"];

$sql = "SELECT id, name, address FROM sample_tb WHERE id = $id;";

try {

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception("Error executing query: " . $conn->error);

    } else {
        
        ?> 

        <body style="padding: 10px;">

                <p>I guess you will never know if this is SQLi vulnerable hahahahaha</p>
                <br>
                <button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

        </body>

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


        
    
