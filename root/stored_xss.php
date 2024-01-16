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

$sql = "CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(50))";
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

$server = 'localhost';
$username = 'sandbox_user';
$password = 'password';
$db = 'sample_db';

$conn = new mysqli($server, $username, $password, $db);


$content = file_get_contents('code_templates/xss_stored/stored_xss_fn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

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
    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="row">

            <div class="editor_column">

                <form method="post">

                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>
                <br>
                <b>Stored Cross Site Scripting</b>
                <p><b>Background: </b>We will be simulating a comment function where anyone can post anonymously.</p>
                <p>Based on how the comment form is set, we can put in a fake script to illustrate how Stored XSS works.</p>

                <b>Instructions</b>

                <ol>

                    <li>Click <b>Run Code</b>.</li>

                    <br>

                    <li>To initiate this attack, we will need to see how the comment works.</li>

                    <br>

                    <li>Copy the the text below and paste it on the input field, click <b>Submit</b>.
                        <br><br><span class="code_space">Hello World!</span> <button class="buttons" onclick="copyTextOne()">Copy</button>
                    </li>

                    <br>

                    <li>Click on <b>View Messages</b>. You should see that the latest comment is being stored and reflected back to you.</li>

                    <br>

                    <li>To determine if the input is vulnerable to Stored XSS, you can input the following: </li>

                    <p>Copy the code below manually and paste it on the input field. Afer you submit it, return back and click on <b>View Messages</b> again. If there is a pop up, it means the input is vulnerable.</p> <i>Do take note that the code below doesn't necessarily apply to only Stored XSS, but it can also be applicable to DOM or Reflected </i>.</p>

                    <span class="code_space">&lt;script&gt;alert('Stored XSS Attack');&lt;/script&gt; </span><button class="buttons" onclick="copyTextTwo()">Copy</button></p>

                    <li><b>Refresh</b> the page </li>
                    <br>
                    <li>And now, with the intention of redirecting users to a Phishing page when they view the messages, copy the code manually and paste it on the input field.</li> <br>
                    <span class="code_space"> &lt;script&gt;window.location = 'phished.php';&lt;/script&gt;</span><button class="buttons" onclick="copyTextThree()">Copy</button>
                    <p>After submitting, return back and click on <b>View Messages</b> again. It will now redirect you to a different website. Simulating how it can be used for Phishing attacks.</p>

                </ol>

                <a href="stored_xss_backend.php"><button class="buttons">View Stored Cross Site Scripting back-end</button></a>

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
                var copyText = "Hello World!";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextTwo() {
                var copyText = '<sc' + 'ript>alert("Stored XSS Attack!")</scr' + 'ipt>';
                navigator.clipboard.writeText(copyText);
            }

            function copyTextThree() {
                var copyText = "<sc" + "ript>window.location='phished.php'</scr" + "ipt>";
                navigator.clipboard.writeText(copyText);
            }
        </script>


    </div>

</body>

</html>