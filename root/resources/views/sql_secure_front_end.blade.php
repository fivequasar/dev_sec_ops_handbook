<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/sqli_secure/sql_secure_fn.php');

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


@include('layouts.navigation')

    <div class="main">

    <div class="row">

        <div class="editor_column">

        <form method="post">
            @csrf
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Normal Operations</b>
        <p><b>Background: </b>We will be simulating a login system that is secured from SQL Injections.</p>
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

        <p>Try any of the following payloads on the login component above.</p>
        
        <b>Error-based SQli:</b> 

        <br>
        <br>

        <span class="code_space">'</span> <button class="buttons" onclick="copyTextOne()">Copy</button>
        
        <br>
        <br>

        <b>Union-based SQLi:</b>

        <p><span class="code_space" style="margin-right: 10px;">' UNION SELECT name FROM products -- </span> <button class="buttons" onclick="copyTextTwo()">Copy</button></p>
        
        <p>Let's analyse how we have implemented a secure SQLi sandbox by looking at our back-end code:</p>

       <a href="{{route('sql_secure_back_end')}}"><button class="buttons">View Back-End Code</button></a>

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

        
        editor.setSize(null, '500px'); 

        function copyTextOne() {
            var copyText = "'";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "' UNION SELECT name FROM products --";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextOne() {
            var copyText = "";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextOne() {
            var copyText = "";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextOne() {
            var copyText = "";
            navigator.clipboard.writeText(copyText);
        }

    </script>
    
</div>
