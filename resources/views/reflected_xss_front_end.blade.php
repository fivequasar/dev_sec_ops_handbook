<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_reflect/reflected_xss_fn.php');

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

@include('layouts.navigation')

<div class="main">

    <div class="row">

        <div class="editor_column">

        <h3 style="margin: 0px;">Reflected XSS</h3>
        <br>

        <form method="post">
            @csrf
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>
        
        <br>

        <b>Normal Operations</b>

        <p><b>Background:</b> We will be simulating a search function which is unprotected. To see a details of a specific product, a user must provide a name of the product.</p>

        <ol>

        <li>Click <b>Run Code</b>.</li>

        <p>You will see a search query, let's enter a valid input first, copy the text below and paste it in the text box:</p>

        <p><span class="code_space">Apples</span> <button class="buttons" onclick="copyTextOne()">Copy</button></p>

        <li><p>And now try searching using the text below:</p></li>

        <p><span class="code_space">sda@SDA@#DSAD</span> <button class="buttons" onclick="copyTextTwo()">Copy</button></p>

        <li><p>If the product does not exist within the database, it will reflect back the name given by the user, saying there are no results for it.</p></li>

        </ol>

        <b>Performing Reflected XSS</b>

        <ol>

        <li>To find out if a component is vulnerable to XSS, use this payload and enter it in the text box:</li>

        <p><span class="code_space">&lt;script&gt;alert("XSS")&lt;/script&gt;</span> <button class="buttons" onclick="copyTextThree()">Copy</button></p>

        <p>Note that a notification pops up with the message "XSS" on it and that it will not reflect back the name given by the user within the browser. This is because the browser will recognise the payload given as an actual script. This simple proof of concept shows that the search function here is affected by XSS.</p>

        <li><p>Look at the link at your browser when the payload is sent and copy the <b>entire</b> link, it should look something like (Note that the payload you have enter is within the link but it is URL Encoded) </p></li>

        <p class="code_space">http://example.com/xss/reflected_xss_fn_bn.php?name=%3Cscript%3Ealert%28%22XSS%22%29%3C%2Fscript%3E.......</p>

        <li>Paste the link and access it from another tab.</li>

        <p>From the attacker's perspective, they can simply send this link to any user and the XSS alert will be displayed for them when they click on it. </p>

        </ol>


       <a href="{{route('reflect_back_end')}}"><button class="buttons">View Back-End Code</button></a>

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

        
        editor.setSize(null, '350px'); 

        function copyTextOne() {
            var copyText = "Apples";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "sda@SDA@#DSAD";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextThree() {
            var copyText = '<sc' + 'ript>alert("XSS")</scr' + 'ipt>';
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFour() {
            var copyText = " <scr" + "ipt>window.location.href='https://www.youtube.com'</scr" + "ipt>";
            navigator.clipboard.writeText(copyText);
        }

    </script>
    
    </div>
</body>
</html>

