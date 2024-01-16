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

$content = file_get_contents('code_templates/sqli_ib_bn.php');

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

    <b>Error Based Injection</b>
        <p>Let's first analyse line <b>10</b> and <b>12</b>. Notice that the variables for username and passwords are not properly validated. </p>
        <p>When the values that needs to be inserted to the query is not validated properly, MYSQL will catch the error instead of the code catching the error, revealing information regarding the DBMS </p>

        <b>Union/Comment Based Injection</b>
        <p>Now look at line <b>14</b>. Notice that the variables are directly embbeded within the SQL query. This is extremely dangerous, as the query can be manipulated like the union/comment-based injection shown earlier.</p>
        <p>Let's breakdown how the earlier union/comment attack works.</p>

        <p>This is the attacker's input for the username </p>
        <p class="code_space">' UNION SELECT name FROM products -- </p>
        
        <p>When replaced with the username variable within the SQL Query, it will look like this:</p>
        <p class="code_space"><span style="color:purple;">SELECT</span> username <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span> <span style="color:brown;">''</span> <span style="color:purple;">UNION SELECT</span> name <span style="color:purple;">FROM</span> products <span style="color:#CD7F32;">-- ' AND password = '$password';</span></p>
        <p>The first character of the attacker's query is a quotation, this is so that the username command will stil run but SQL will see it as an empty value</p>
        <p class="code_space">SELECT username FROM users WHERE username = <span style="color: red;">''</span> UNION SELECT name FROM products --  ' AND password = '$password';</span></p>

        <p>It then proceeds to perform a union-based attack, for this attack it needs to fit two conditions:</p>

        <ol>
            <li>The original SELECT statement needs to have the same number of columns as the UNION statement.</li>
            <br>
            <li>The UNION column must contain the same data type as the original SELECT statement.</li>
        </ol>

        <p>Looking at the original query, it currently only pulls a single column called <span style="font-family: 'Courier New', Courier, monospace;">username</span> from the <span style="font-family: 'Courier New', Courier, monospace;">users</span> table. Assuming that the attacker knows the name of the other table, it then proceeds to pull a single column called <span style="font-family: 'Courier New', Courier, monospace;">name</span> from the <span style="font-family: 'Courier New', Courier, monospace;">products</span> table</p>
        <p class="code_space">SELECT <span style="color:red;">username</span> FROM <span style="color:red;">users</span> WHERE username = '' UNION SELECT <span style="color:red;">name</span> FROM <span style="color:red;">products</span> -- ' AND password = '$password';</p>
        <p>The attacker then finally comments out the rest of the query using <span style="font-family: 'Courier New', Courier, monospace;">--</span>. This way, the SQL statement will completely ignore the password command, and just run the UNION command instead.  </p>
        <p class="code_space">SELECT username FROM users WHERE username = '' UNION SELECT name FROM products <span style="color:red;"> -- ' AND password = '$password';</span></p>
        <p>And thus, this is what the SQL sees and runs:</p> 
        <p class="code_space"><span style="color:purple;">SELECT</span> username <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span> <span style="color:brown;">''</span> <span style="color:purple;">UNION SELECT</span> name <span style="color:purple;">FROM</span> products</p>

    </div>

    <div class="output_column">

    <form method="post">

    <div class="output_column code_font">

        <?php echo $output;?>

    </div>

    <textarea id="code" name="code"><?php echo $code; ?></textarea>
    <br>
    <input type="submit" value="Run Code >" class="buttons">

    </form>
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

