<?php

$server = $server_var;
$username = $username_var;
$password = $password_var;
$db = $db_var;

$conn = new mysqli($server, $username, $password, $db);

$name = ''; //Insert the script here

$sql = "SELECT id, name, country FROM products WHERE name LIKE ?";

try {

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("s", $name);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Error executing query: " . $conn->error);
    } else {

        ?>

        <h1>Results:</h1>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " Name: " . $row["name"] . " Country: " . $row["country"] . "<br>";
            }
        } else {
            echo "0 results for $name";
        }
        $conn->close();
        ?>
        <br>
        <br>
        <button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

        <?php

    }

} catch (Exception $e) {

    echo $e->getMessage();

    ?>

    <br><br><button onclick="history.back()" style="padding: 7px 10px 7px 10px; background-color: #252525;color: white; border-radius: 8px;">Go Back</button>

    <?php

    $conn->close();
    $stmt->close();
}
?>
