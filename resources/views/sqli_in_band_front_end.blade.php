<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

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


@include('layouts.navigation')


    <div class="main">

        <div class="row">

            <div class="editor_column">
    
            <table>
                    <tr>
                        <td>
                            <h3 style="margin: 0px 10px 0px 0px;">Error-Based SQLi</h3>
                        </td>
                        <td>
                            <a href="{{route('in_band_front_union_end')}}"><button class="buttons">Swap to Union-Based Demo</button></a>
                        </td>
                    </tr>
            </table>
    
            <br>
    
            <form method="post">
                @csrf
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
                        <li>The structure of the query is made up of <span style="font-family: 'Courier';">''' AND password = '''</span></li>
                        <br>
                    </ul>
    
                <li>Although the information here may seem minor, it can be used by an attacker to perform greater attack.</li> 
    
            </ol>

            <p>Let's analyse the back-end code. Click Below.</p>
    
            <a href="{{route('in_band_back_end')}}"><button class="buttons">View Error-based Back End</button></a>
    
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

