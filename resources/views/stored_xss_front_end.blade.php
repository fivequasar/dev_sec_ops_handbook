<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_stored/stored_xss_fn.php');

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="codemirror/codemirror.css">
    <link rel="stylesheet" href="codemirror/ayu-dark.css">
    <script src="codemirror/codemirror.js"></script>
    <script src="codemirror/matchbrackets.js"></script>
    <script src="codemirror/htmlmixed.js"></script>
    <script src="codemirror/xml.js"></script>
    <script src="codemirror/javascript.js"></script>
    <script src="codemirror/css.js"></script>
    <script src="codemirror/clike.js"></script>
    <script src="codemirror/php.js"></script>
</head>
<body>

@include('layouts.navigation')

    <div class="main">
        
    <div class="row">
        <div class="editor_column">

        <h3 style="margin: 0px 10px 0px 0px;">Stored XSS</h3>
        <br>

        <form method="post">
            @csrf
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Normal Operations</b>
        <p><b>Background: </b>We will be simulating a message forum</p>
        <p>Users will be able to <b>view message</b> and <b>submit their own</b>.</p>

        <ol style="padding-left: 20px;">
            <li>Click <b>Run Code</b>.</li>
            <br>
            <li>Type anything in the message box, click <b>Submit</b> and go back.</li>
            <br>
            <li>Click on <b>View Messages</b>.</li>
            <br>
            <li>From here, the messages are pulled from the database.</li>
            <br>
            <li>You will see the the messages that you have sent append to the end of the list.</li>

        </ol>

        <b>Performing Stored XSS</b>

        <ol>

        <li><p>Copy the following text and paste it in the message box:</p></li>

        <p><span class="code_space" style="margin-right: 10px;">&lt;script&gt;alert("XSS")&lt;/script&gt;</span> <button class="buttons" onclick="copyTextOne()">Copy</button></p>

        <li><p>Click <b>Submit</b> and go back.</p></li>

        <li><p>Now click on <b>View Message</b></p></li>

        </ol>

        <p>The message forum has now been infected with XSS. As an attacker, we could choose to redirect users to another website, below is an example of a redirection to youtube.com</p>

        <ol>

        <li><p>Copy the following text and paste it in the message box:</p></li>

        <p><span class="code_space" style="margin-right: 10px;">&lt;script&gt;window.location.href='https://www.youtube.com'&lt;/script&gt;</span> <br><br> <button class="buttons" onclick="copyTextTwo()">Copy</button></p>

        <li><p>Click <b>Submit</b> and go back.</p></li>

        <li><p>Now click on <b>View Message</b></p></li>
        
        </ol>

        <p>In an attempt to perform a phishing attack, an attacker can redirect the user to a similar looking website, fooling the victim into logging in again, in an attempt to steal credentials.</p>


    

        <p>Let's analyse the back-end code. Click Below.</p>    

        <a href="{{route('submit_back_end')}}"><button class="buttons">View Stored XSS (Submit Message Function) Back End</button></a>

        <br>

        <br>

        <a href="{{route('view_back_end')}}"><button class="buttons">View Stored XSS (View Message Function) Back End</button></a>

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
            var copyText = '<sc' + 'ript>alert("XSS")</scr' + 'ipt>';
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = " <scr" + "ipt>window.location.href='https://www.youtube.com'</scr" + "ipt>";
            navigator.clipboard.writeText(copyText);
        }
    </script>
    
    </div>

</body>
</html>

