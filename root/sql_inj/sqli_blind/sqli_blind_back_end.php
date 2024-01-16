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

$sql = "INSERT INTO users (username, password) VALUES ('administrator', 'password');";
$conn->query($sql);

$sql = "CREATE USER IF NOT EXISTS 'sandbox_user'@'localhost' IDENTIFIED BY 'password';";
$conn->query($sql);

$sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON sample_db.* TO 'sandbox_user'@'localhost';";
$conn->query($sql);

$sql = "FLUSH PRIVILEGES;";
$conn->query($sql);

$conn->close();

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$content = file_get_contents('code_templates/sqli_b_bn.php');

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
        <b>Boolean Based Attack</b>
        <p>We'll be focusing on line <b>10</b> and <b>12</b>. </p>
        <p>For line <b>10</b>, the data is stored on the variable $id. This variable should be properly validated, ensuring that (in this case) only numbers are allowed to be handled, any other form of data is ought to be rejected.</p>
        <p>Moving on to line <b>12</b> the $id variable which handles the data is directly embedded in the SQL query, this is considered a bad practice as attackers have direct control and can manipulate the SQL directly before it is sends to the database. </p>

        <p>Let's analyse how the earlier attack's work. These are the payload's used:</p>
        
        

        <p></p>

        <ol>

            <li><span class="code_space">1 AND 1 = 2</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">2</span>;</span></p>
                <p>When the SQL receives the value AND 1 = 2, it will  return false as 1 does not equate to 2, which will return no entries within the WHERE clause.</p>

            <br>

            <li><span class="code_space">1 AND 1 = 1</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">1</span>;</span></p>
                <p>When the SQL receives the value AND 1 = 1, it will return true as 1 equates to 1, it will return the specified entry within the WHERE clause.</p>

            <br>

            <li><span class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='admin')</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:purple;">EXISTS</span>( <span style="color:purple;">SELECT</span> <span style="color:deeppink">*</span> <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span><span style="color:brown"> 'admin' </span>) </p>
                <p>When the SQL receives the command above, SQL will check that if the username 'admin' exist within the users table, if it does it will return an entry of ID 1, else it wouldn't return anything. </p>

            <li><p class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='administrator')</p></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:purple;">EXISTS</span>( <span style="color:purple;">SELECT</span> <span style="color:deeppink">*</span> <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span><span style="color:brown"> 'administrator' </span>)</p>
                <p>When the SQL receives the command above, SQL will check that if the username 'administrator' exist within the users table, if it does it will return an entry of ID 1, else it wouldn't return anything. </p>
        </ol>

        <button class="buttons" onclick="history.back()">Return</button>
        
        </div>

        <div class="output_column code_font">

            <div class="output_column code_font">

                <?php echo $output;?>

            </div>

        <form method="post">

            <textarea id="code" name="code"><?php echo $code; ?></textarea>
            <br>
            <input type="submit" value="Run Code >" class="buttons">

        </form>

        </div>
        
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

        editor.setSize(null, '1150px'); 
    </script>

</div>
</body>
</html>

