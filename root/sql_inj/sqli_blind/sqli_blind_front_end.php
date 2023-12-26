<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$content = file_get_contents('code_templates/sqli_b_fn.php');

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

    <a href="sqli_prevention.php">SQLI Prevention</a>

    <a href="/root/xss_home.php">XSS</a>

</div>

    <div class="main">

    <div class="row">

        <div class="editor_column">
        
        <form method="post" action="sqli_blind_front_end.php">
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>
      
        <br>

        <b>Normal Operations</b>
        <p><b>Background: </b>We will be simulating a search function which is unprotected</p>
        <p>Based on the ID given by the user, it will retrieve and display the name and the address based on the ID.</p>

        <b>Boolean Based Attack</b>

        <ol>

                <li>Click <b>Run Code</b>.</li>

                 <br>

                <li>To initiate this attack, we will need to enter one legitamate input first.</li>

                <br>

                <li>Copy the the text below and paste it on the ID search bar, click <b>Submit</b>.<br><br><span class="code_space">1</span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>
                
                <br>

                <li>You will see the country of origin and the name of the product.</li>

                <br>

                <li>To determine if a component is vulnerable to SQL Injection, an attacker could input the following: </li>

                <p>Copy the code below. If the application returns nothing, it is vulnerable to SQLi</p>

                <p><span class="code_space">1 AND 1 = 2</span> <button class="buttons" onclick="copyTextTwo()">Copy</button></p>

                <p>To confirm, copy the code below. If the application returns an entry, it is vulnerable to SQLi</p>

                <p><span class="code_space">1 AND 1 = 1</span> <button class="buttons" onclick="copyTextThree()">Copy</button></p>

                <p>And now, with the intention of finding out if the users table has an account named "admin", an attacker can perform:</p>
                <p><span class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='admin') </span> <br><br><button class="buttons" onclick="copyTextFour()">Copy</button></p>
                <p>It will return no entry, thus meaning the username admin in the users table does not exist.</p>

                <p>The attacker then tries to find out if the users table has the username "administrator", an attacker can perform:</p>
                <p><div class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='administrator') </div><button class="buttons" onclick="copyTextSeven()">Copy</button></p>
                <p>It will return an entry, thus meaning that the username administrator does indeed exist in the users database.</p>

        </ol>

        
        <p>Let's analyse the back-end code. Click Below.</p>

        <a href="sqli_blind_back_end.php"><button class="buttons">View Boolean-Based attack back-end</button></a>

        <br>
        <br>

        <b>Time Based Attack</b>

        <br>
        <br>

        <b>Normal Operations</b>
        <p>When a user searches an item, it will say "Searched!", even if the items either exist or do not.</p>

        <ol>

                <li>Within the code, change the action attribute of the form tag to: </li>

                <p><span class="code_space">code_templates/sqli_tb_fn_bn.php</span> <button class="buttons" onclick="copyTextFive()">Copy</button></p>

                <li>Click <b>Run Code</b>.</li>
                
                <br>

                <li>In some instances, performing boolean-based attacks may not directly reveal the results of it. This is where time-based attacks come in, to determine whether if the component is vulnerable to SQLi or not, instead of using 1= 1 AND 1, an attacker can use:</li>

                <p><span class="code_space">1 AND IF(1=1, SLEEP(5), SLEEP(0))</span> <button class="buttons" onclick="copyTextSix()">Copy</button></p>
                
                <li>This essentially means that if 1 = 1 is true, wait for 5 seconds then execute or if false, execute it immediately. By entering the following in the parameter, and the websites responds by loading, it is SQL vulnerable.</li>

                <br>

                <li>The attacker then attemps to verify if the username 'admin' exist from the users table.</li>

                <p><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='admin'), SLEEP(5), SLEEP(0))</div><button class="buttons" onclick="copyTextEight()">Copy</button></p>

                <p>If when pressing submit, and the page dosen't show it's loading, it means that the username 'admin' does not exist in the users table. Now the attacker tries to find out if the username 'administrator' exist from the users table.</p>

                <p><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='administrator'), SLEEP(5), SLEEP(0))</div><button class="buttons" onclick="copyTextNine()">Copy</button></p>

                <p>If when pressing submit, and the page shows it's loading, it means that the username 'administrator' does exist in the users table.</p>

        </ol>

        
        <p>Let's analyse the back-end code. Click Below.</p>

        <a href="sqli_blind_time_back_end.php"><button class="buttons">View Time-Based attack back-end</button></a>

        

        </div>

        <div class="output_column code_font">

            <?php echo $output; ?>

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

        editor.setSize(null, '330px'); 

        function copyTextOne() {
            var copyText = "1";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "1 AND 1 = 2";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextThree() {
            var copyText = "1 AND 1 = 1";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFour() {
            var copyText = "1 AND EXISTS( SELECT * FROM users WHERE username ='admin') ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFive() {
            var copyText = "code_templates/sqli_tb_fn_bn.php";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextSix() {
            var copyText = "1 AND IF(1=1, SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }
        
        function copyTextSeven() {
            var copyText = "1 AND EXISTS( SELECT * FROM users WHERE username ='administrator') ";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextEight() {
            var copyText = "1 AND IF(EXISTS(SELECT * FROM users WHERE username ='admin'), SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextNine() {
            var copyText = "1 AND IF(EXISTS(SELECT * FROM users WHERE username ='administrator'), SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }
    </script>

</div>

</body>
</html>

