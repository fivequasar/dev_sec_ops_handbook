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

$sql = "CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia');";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO users (username, password) VALUES ('john', 'password');";
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

        <a href="xss_home.php">XSS</a>

    </div>

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/blind.png');" > 

        <h2 style="margin-top: 0px;">Blind SQLi</h2>
    
        <p><b>Description: </b>An attacker sends a payload over and based on the results and reaction given by the server, then proceeds to build a profile on the architecture of the database. This process may take longer compared to in-band SQLi as the results of the payload may not be directly reflected and it heavily relies on how the web application reacts to it. </p>  
        

    </div>

</div>

<br>

    <div class="description">

        <div class="sub_description" style="background-image: url('images/blind.png');">

        <h2 style="margin-top: 0px;">Boolean-based</h2>

        <p><b>Description: </b>Boolean-based SQL injections is when an attacker crafts a SQL query in an attempt to force the application to send back either any response with two outcomes (True or False).</p>

        <p><b>Example: </b>An attacker performs an boolean based SQLi on a search function.</p>

            <ol class="list">
                
                <li>The SQL query in the back end looks like this:</li>
                    <br>
                <span class="code_space">SELECT name, price FROM product WHERE name = '$name';</span>
                    <br>
                    <br>
                <li>Based on this query, an attacker will first need to enter a valid input, in this case is:</li>
                    <br>
                <span class="code_space">Apples</span>
                    <br>
                    <br>
                <li>The query will now look like this:</li>
                    <br>
                <span class="code_space"><span style="color:purple;">SELECT</span> * <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> name <span style="color:deeppink;">=</span> <span style="color:darkred;">'Apples'</span>;</span>
                    <br>
                    <br>
                <li>If the SQL returns with a result of the name and price of Apples, the attacker can now try:</li>

                <p><span class="code_space">Apples' AND 1 = 1 -- </span></p>

                <p><span class="code_space">Apples' AND 1 = 2 -- </span></p>

                <li>By performing the first line and receiving the name and price of Apples, but not returning anything from the second command, makes it vulnerable to SQL injection.</li>
                    <br>
                <li>When both commands are placed in the query, it will look like this:</li>
                    <br>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:darkred;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:green;">1 <span style="color:deeppink;">=</span> 1</span> <span style="color:#CD7F32;">-- '</span></div>
                <p>When the SQL receives the value 'AND 1 = 1', it will return true as 1 equates to 1, it will then return the specified entry within the WHERE clause.</p>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:darkred;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:green;">1 <span style="color:deeppink;">=</span> 2</span> <span style="color:#CD7F32;">-- '</span></div>
                <p>When the SQL receives the value 'AND 1 = 1', it will return true as 1 equates to 1, it will then return the specified entry within the WHERE clause.</p>

                <li>The attacker can then proceed to perform:</li>
                    <br>
                <div class="code_space">Apples' AND EXISTS( SELECT * FROM users WHERE username ='admin')-- '</div>
                    <br>
                <li>The query now looks like:</li>
                    <br>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:green;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:purple;">EXISTS</span>(<span style="color:purple;">SELECT</span> * <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username = <span style="color:green;">'admin'</span>)<span style="color:#CD7F32;">-- '</span></div>
                    <br>                
                <li>An attacker may now attempt brute force attacks to determine if there is a username named 'admin' within the user's table. If the entry returns then it would be true, or else, it would be false.</li>

            </ol>
                <p><b>Consequences: </b>When these boolean-attacks are allowed within an input, an attacker can use this vulnerability to enumarate the database through either true, or false results given by the application.</p>

    </div>

    <div class="sub_description" style="background-image: url('images/in_band.png');">

    <h2 style="margin-top: 0px;">Time-based</h2>

        <p><b>Description: </b>An attackers use the SQL operator <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span>. This operator when used in a SQL query combines the results of two or more <span class="code_space" style="padding: 2px 10px 2px 10px;">SELECT</span> statements. If misused, this operator can result in the display of data from other tables within the database. </p>

        <p><b>Example: </b>An attacker performs an union based SQLi on a search function.</p>

        <ol class="list">
            <li>This is the query that is used:</li>
                <br>
            <span class="code_space">SELECT name, price FROM products WHERE name = '$name';</span>
                <br>
                <br>
            <li>The attacker enters the following input:</li>
                <br>
            <span class="code_space">'UNION SELECT username, password FROM users -- </span>
                <br>
                <br>
            <li>The query will now look like this:</li>
                <br>
            <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = ''<span style="color:purple;">UNION </span> <span style="color:purple;">SELECT</span> username, password <span style="color:purple;">FROM</span> users <span style="color:#CD7F32;">-- '</span></div>
                <br>
            <li>Within the attacke's payload, the attacker first used a quotation at the start so as to close the quotation of the original query, allowing the <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command to work.</li>
                <br>
            <div class="code_space">SELECT name, price FROM product WHERE name = <span style="color:red;">''</span> UNION SELECT username, password FROM users -- '</div>
                <br>
            <li>For a <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command to work, it needs to fit two conditions:</li>

            <ol>
                <br>
            <li>Both the number of columns in the original <span class="code_space" style="padding: 2px 10px 2px 10px;">SELECT</span> and <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> needs to be the same. In this case the <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command gets the username and password from the users table in that database.</li>
                <br>
            <div class="code_space">SELECT <span style="color:red;">name, price</span> FROM product WHERE name = '' UNION SELECT <span style="color:red;">username, password</span> FROM users -- '</div>
                <br>
            <li>It needs to be the same data type.</li>
            </ol>
                <br>
            <li>Finally, the attacker uses the <span class="code_space" style="padding: 2px 10px 2px 10px;">--</span> command to comment out the last quotation, allowing the command to run with no issue. The attacker will now be able to see all the username and password credentials of the user's table.</li>
                <br> 
            <div class="code_space">SELECT name, price FROM product WHERE name = '' UNION SELECT username, password FROM users <span style="color:red;">-- '</span></div>

        </ol>

        <p><b>Consequences: </b>When attackers are allowed to use the UNION operator within an input, an attacker can retrieve almost every information within the database.</p>

        </div>

</div>


<br>

    <div class="description">

        <a href="sql_inj/sqli_blind/sqli_blind_front_end.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Blind SQLi Sandbox Demo ></button></a>

    </div>

</div> 

</body>
</html> 
