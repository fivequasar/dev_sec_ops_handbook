<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_in_band/sqli_ib_fn.php');

$output = "";

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w") ;
    
    fwrite($myfile, $code);
    
    ob_start();
    
    include 'code.php';
    
    $output = ob_get_contents();
    
    ob_end_clean();
    
    unlink("code.php");

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

        <table>
        <tr>
            <td>
                <h3 style="margin: 0px 10px 0px 0px;">Union-Based SQLi</h3>
            </td>
            <td>
            <a href="sqli_in_band_front_end.php"><button class="buttons">Swap to Error-Based Demo</button></a>
            </td>
        </tr>
        </table>

        
        <br>

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

        <b>Union-Based SQL</b>

        <p>In this scenario we will attempt to comment out the password and use the "UNION" command to pull another table's data named <span style="font-family: 'Courier';">products</span> within the same database.</p>

        <ol style="padding-left: 20px;">

            <li>Click <b>Run Code</b>.</li>

            <br>

            <li>Copy the the text below and paste it on the username, click <b>Submit</b>.<br><br><span class="code_space">' UNION SELECT name FROM products -- </span> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>
            
            <br>

            <li>Noticed how the username are not of the user table, it is instead pulling the names from the products table and because of the UNION command, replaced the name column of the products table as the message column. The point here is that attackers can extract data of other tables within the same database.</button></li>

            <br>
            
        </ol>

        <p>Let's take a look at the backend of the code. Click Below:</p>

        <a href="sqli_in_band_union_back_end.php"><button class="buttons">View Union-based Back End</button></a>

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

