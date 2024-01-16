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

        <b>Reconnaissance</b>


        <p>For an attacker to perform a union-based attack, it needs to fulfil two conditions:</p>

        <ol>
            <li>The original SELECT statement needs to have the same number of columns as the UNION statement.</li>

            <p>To determine how many columns are there within the query, copy it within the username field and send it over each row one by one:</p>

            <p><span class="code_space" style="margin-right: 10px;">' ORDER BY 1-- </span> <button class="buttons" onclick="copyTextOne()">Copy</button></p>

            <p><span class="code_space" style="margin-right: 10px;">' ORDER BY 2-- </span> <button class="buttons" onclick="copyTextTwo()">Copy</button></p>

            <p><span class="code_space" style="margin-right: 10px;">' ORDER BY 3-- </span> <button class="buttons" onclick="copyTextThree()">Copy</button></p>

            <p>The numbers within the payload represents the number of columns within the query. If it returns no errors, increase the number within the payload and keep sending it until an error occurs. It should look something like this: </p>

            <p><span class="code_space">Unknown column '2' in 'order clause'</span></p>

            <p>When it does, minus one and that will be the number of columns within the query. In this case, we now know that the number of columns within the SELECT query is 1 as an error occurs when we enter the payload <span class="code_space" style="padding: 2.5px;">' ORDER BY 2-- </span>.</p>

            <li>It needs to be the same data type.</li>

            <p>Next, the attackers need to find out whether this single "column" is willing to accept string data (except for mysql), copy the payload below and paste it in the username field:</p>

            <p><span class="code_space" style="margin-right: 10px;">' UNION SELECT 'a' -- </span> <button class="buttons" onclick="copyTextFour()">Copy</button></p>

            <p>If it returns no errors, it means that it is willing to accept string types.</p>

        </ol>
        

            <p>With both information at hand, the attacker now can perform a union-based attack. Now we know that:</p>
            <li>The query is containing only a <b>single</b> column.</li>
            <li>The column can accept <b>strings</b>.</li>

            <br>
        
        <b>Performing Union-Based attacks</b>

        <ol>

        <li><p>The attacker then decides to find out the current database user that this login component is using to connect to the database. By using the following payload:</p></li>

        <p><span class="code_space" style="margin-right: 10px;">' UNION SELECT current_user() -- </span> <button class="buttons" onclick="copyTextFive()">Copy</button></p>

        <p>Based on the result, the attacker now knows the database username</p>

        <li><p>Assume that the attacker knows that there is a products table within the database, based on what the attacker has learnt, the attacker can also perform:</p></li>

        <p><span class="code_space" style="margin-right: 10px;">' UNION SELECT name FROM products -- </span> <button class="buttons" onclick="copyTextSix()">Copy</button></p>

        <p>Noticed how the username are not of the user table, it is instead pulling the names from the products table and because of the UNION command, replaced the name column of the products table as the message column. </p>

        </ol>

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
            var copyText = "' ORDER BY 1-- ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "' ORDER BY 2-- ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextThree() {
            var copyText = "' ORDER BY 3-- ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFour() {
            var copyText = "' UNION SELECT 'a' -- ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFive() {
            var copyText = "' UNION SELECT current_user() -- ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextSix() {
            var copyText = "' UNION SELECT name FROM products --  ";
            navigator.clipboard.writeText(copyText);
        }
    </script>
    
    </div>

</body>
</html>

