<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_reflect/reflected_xss_bn.php');

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

        <h3 style="margin: 0px;">Reflected XSS Back End</h3>
        <br>   

        <form method="post">
            @csrf
            <textarea id="code" name="code"><?php echo $code; ?></textarea>
            <br>
            <input type="submit" value="Run Code >" class="buttons">
            <br>
        </form>

        <p>Scroll down and take a look at line <b>31</b> and line <b>34</b>. Notice that whenever the echo is used to display the results of the products based on the name provided by the user, it is not properly encoded.</p> 

        <p>To prevent XSS, any data that is shown, albeit from a database or anything that is <b>reflected</b> back to the user should be encoded.</p> 

        <a href="{{route('reflect_front_end')}}"><button class="buttons">View Front-End Code</button></a>

        </div>

        <div class="output_column">

            <?php echo $output; ?> 
            
            <br>


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

        
        editor.setSize(null, '600px'); 

        function copyTextOne() {
            var copyText = "' UNION SELECT name FROM products --";
            navigator.clipboard.writeText(copyText);
        }

    </script>
    
    </div>
</body>
</html>

