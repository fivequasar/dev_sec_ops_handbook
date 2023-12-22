<?php

$server = 'localhost';
$username = 'root';
$password = '';

$connOne = new mysqli($server, $username, $password);

$sql = "DROP USER IF EXISTS 'sandbox_user'@'localhost';";
$connOne->query($sql);

$sql = "DROP DATABASE IF EXISTS sample_db;";
$connOne->query($sql);

$connOne = new mysqli($server, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS sample_db;";
$connOne->query($sql);

$db = 'sample_db';

$conn = new mysqli($server, $username, $password, $db);

$sql = "USE sample_db;";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS sample_tb (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), address VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO sample_tb (name, address) VALUES ('John Doe', '123 Main St'), ('Jane Smith', '456 Elm St'), ('Alice Johnson', '789 Oak St'), ('Bob Brown', '101 Maple Ave');";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20), message VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO users (username, password, message) VALUES ('john', 'password', 'I Love Chinese Food!');";
$conn->query($sql);

$sql = "CREATE USER IF NOT EXISTS 'sandbox_user'@'localhost' IDENTIFIED BY 'password';";
$conn->query($sql);

$sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON sample_db.* TO 'sandbox_user'@'localhost';";
$conn->query($sql);

$sql = "FLUSH PRIVILEGES;";
$conn->query($sql);

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <div class="vertical-menu">
        <a href="index.php">Home</a>
        <a href="sqli-home.php" >SQL Injection</a>
        <a href="xss-home.php">XSS</a>
    </div>

<!-- <div class="main" style="background-image: url('/v/images/sqli.png'); background-position-x: 98%; background-position-y: 50%; background-size: 1500px 1464.84px;background-repeat: no-repeat;"> -->

<div class="main">

<h2 style="margin-top: 0px;">SQL Injection</h2>

<b>Description:</b>

    <p>SQL Injection, otherwise known as SQLI, is a type of injection where a malicious actor uses a SQL command on any website that require data input. Based on the predefined SQL commands configured behind the application, the attacker can potentially change the results of the execution based on the commands send over from the attacker to the application. If an attack is successful, an attacker can cause damage to the database by exposing data, modifying data, destroying data, cause repudiation issues and potentially get granted administrative privileges of the database. </p>
        
    <br><b class="sub_head">In-Band SQLi</b>

    <div class="description">

    <p>Being the most common type of SQLi attack, the attacker launches and obtains the results of the attack on the same communication path. This category is split into two. </p>
        
        <!-- <div class="sub_description" style="background-image: url('/v/images/in_band.png');"> -->

        <div class="sub_description">

            <ol>

                    <li>Error-based SQLi</li>

                    <p>An attacker purposely performs actions that may cause the database to produce error messages. These error messages may provide information regarding to the architecture of the database.</p>

                    <li>Union-based SQLi</li>

                    <p>An attackers use the SQL operator “UNION”. This operator when used in a SQL query combines the results of two or more SELECT statements. If misused, this operator can result in the display of data from other tables that are not authorised to be shown.</p>
            
                    
            </ol>
        
        </div>

        <a href="sql_inj/sqli_in_band/sqli_in_band_front_end.php"><button class="buttons">Sandbox Demo</button></a>

    </div>

    <br><br><b class="sub_head">Blind SQLI</b>

    <div class="description">

    <p>An attacker sends a payload over and based on the results and reaction given by the server, then proceeds to build a profile on the architecture of the database. </p>

        <!-- <div class="sub_description"  style="background-image: url('/v/images/blind.png'); background-position-y: 50%; background-size: 125px 166.67px;"> -->

        <div class="sub_description">

            <ol>
            
                <li>Boolean</li> 

                <p>Attackers force the web application to give a true or false response in order to find out if it is vulnerable to SQL injections. In response to a web application's response, attackers can determine the effectiveness of their payload.</p>

                <li>Time-based</li>

                <p>In a scenario when the attacker is unable to see the results of their payload being either true or false, another way is to set a time-based injection. Using this method, an attacker can modify the SQL query to make the database delay its response if certain conditions are met. The response time of the database can tell attackers if their SQL query is true or false.</p>

            </ol>

        </div>

        <a href="sql_inj/sqli_blind/sqli_blind_front_end.php"><button class="buttons">Sandbox Demo</button></a>

    </div>

    <br><br><b class="sub_head">Out-of-band SQLI</b>

    <div class="description" style="padding-bottom: 5px;">
    
    <p>Where in-band and blind SQLi both receives some form of response back to the attacker, out-of-band SQL Injections sends the response to an attacker's remote endpoint.</p> 

    </div>

    <br>


        <b>SQLi Prevention Measures</b>

        <br>
        <br>

        <img src="images/sqli_pm.png" class="center_image"> 

        <br>

        <p>The two-layer architecture aims to guide developrs into creating a secure environment safe from SQLi attacks.</p> 

        <ol>

        <li>First layer of defence: Input Validation using preg_match()</li>

        <p>Have a habit of never trusting any user input, this is why sanitizing the input is super important. Using preg_match can help with sanitization.</p>

        <li>Second layer of defence: Prepared Statements</li>

        <p>Using prepared statements splits the SQL commands and the input data apart from each other, which in a way prevents SQL injections. </p>

        </ol>

        <a href="sql_inj/sqli_blind/sqli_blind_front_end.php"><button class="buttons">Sandbox Demo</button></a>
    
</div> 

</div>

</body>
</html> 
