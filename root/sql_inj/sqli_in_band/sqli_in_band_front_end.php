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

$sql = "CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(20))";
$conn->query($sql);

$sql = "INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')";
$conn->query($sql);

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

$content = file_get_contents('code_templates/sqli_ib_fn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w") ;
    
    fwrite($myfile, $code);
    
    ob_start();
    
    @include("code.php");
    
    $output = ob_get_contents();
    
    ob_end_clean();
    
    unlink("code.php");

} else {

    $code = $content;
    $output = "";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/root/css/style.css">
    <link rel="stylesheet" href="/root/codemirror/codemirror.css">
    <link rel="stylesheet" href="/root/codemirror/ayu-dark.css">
    <script src="/root/codemirror/codemirror.js"></script>
    <script src="/root/codemirror/matchbrackets.js"></script>
    <script src="/root/codemirror/htmlmixed.js"></script>
    <script src="/root/codemirror/xml.js"></script>
    <script src="/root/codemirror/javascript.js"></script>
    <script src="/root/codemirror/css.js"></script>
    <script src="/root/codemirror/clike.js"></script>
    <script src="/root/codemirror/php.js"></script>
</head>
<body>

<div class="vertical-menu">

        <a href="/root/index.php">Home</a>

        <a href="/root/sqli_home.php" >SQL Injection</a>

        <a href="/root/sqli_in_band.php" >In-Band SQLI</a>

        <a href="/root/sqli_blind.php" >Blind SQLI</a>

        <a href="/root/sqli_oob.php">OOB SQLI</a>

        <a href="/root/sqli_prevention.php">SQLI Prevention</a>

        <a href="/root/xss_home.php">XSS</a>
</div>

    <div class="main">

    <div class="row">

        <div class="editor_column">

        <form method="post">
            
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Normal Operations</b>
        <p><b>Background: </b>We will be simulating a login system that is unprotected</p>
        <p>Let's first find out how to login component works, the user enters the username and the password and will receive a custom welcome message with it's username retrieved from the users table. Currently there is only one entry in this table which are: </p>

        <table>
        <tr style="text-align: left;">
            <th>Username</th>
            <th>Password</th>
        </tr>
        <tr>
            <td><span>administrator</span></td>
            <td><span>password</span></td>
        </tr>
        </table>

        <ol style="padding-left: 20px;">
            <li>Click <b>Run Code</b>.</li>
            <br>
            <li>Enter the username and password accordingly.</li>
            <br>
            <li>You will receive the message "Welcome, administrator. Login Successful".</li>
        </ol>

        <b>Error Based SQL</b>
        <br>

        <ol style="padding-left: 20px;">

            <li>Click <b>Run Code</b>.</li>

            <br>
            <li>Copy the the text below and paste it on the username, click <b>Submit</b>. You will see an error.<br><br><span class="code_space">'</span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>
            <br>

            <li>From the error you can deduce that: </li>

            <br>
                <ul>
                    <li>The database management system is MariaDB</li>
                    <br>
                    <li>The structure of the query is made up of <span style="font-family: 'Courier';">'' AND password = ' </span> and <span style="font-family: 'Courier';"> 'SELECT * FROM u...'</span></li>
                    <br>
                    <li>Path of the file for the login component</li> 
                    <br>
                </ul>

            <li>Although the information here may seem minor, it can be used by an attacker to perform greater attack.</li> 

        </ol>

        <b>Union/Comment Based SQL</b>

        <p>Sometimes, attackers can use a mix of two different types of attacks, in this scenario we will attempt to comment out the password and use the "UNION" command to pull another table's data named <span style="font-family: 'Courier';">products</span> within the same database.</p>

        <ol style="padding-left: 20px;">

            <li>Click <b>Run Code</b>.</li>

            <br>

            <li>Copy the the text below and paste it on the username, click <b>Submit</b>.<br><br><span class="code_space">' UNION SELECT name FROM products -- </span> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>
            
            <br>

            <li>Noticed how the username are not of the user table, it is instead pulling the names from the products table and because of the UNION command, replaced the name column of the products table as the message column. The point here is that attackers can extract data of other tables within the same database.</button></li>

            <br>
            
        </ol>

        <p>Let's take a look at the backend of the code. Click Below:</p>

        <a href="sqli_in_band_back_end.php"><button class="buttons">View Back End</button></a>

        </div>

        <div class="output_column code_font"><?php echo $output; ?></div>
        
    </div>

    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            theme: "ayu-dark"
        });

        editor.setSize(null, '425px'); 

        function copyTextOne() {
            var copyText = "'";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "' UNION SELECT name FROM products --  ";
            navigator.clipboard.writeText(copyText);
        }
    </script>
    
    </div>

</body>
</html>

