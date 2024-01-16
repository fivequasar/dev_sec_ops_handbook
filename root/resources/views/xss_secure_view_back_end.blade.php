<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_secure/secure_xss_bn.php');

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

                <form method="post">
                    @csrf
                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>

                <br>

                <b>Secured From XSS View Function using htmlspecialchar().</b>

                <p>Take a look at line <b>17</b>. For any data that <b>reflects back user-supplied data</b> or when <b>data is being pulled from your database</b>, it should be enclosed in <b style="font-family:'Courier New', Courier, monospace">htmlspecialchar()</b></p>

                <p>That way, any inputs that are going towards the browser will then be instructed to change any special characters like "<b style="font-family:'Courier New', Courier, monospace"><</b>" and "<b style="font-family:'Courier New', Courier, monospace">></b>" to <b style="font-family:'Courier New', Courier, monospace" >&amp;lt;</b> and <b style="font-family:'Courier New', Courier, monospace">&amp;gt;</b>, which is a HTML representation of the symbol and will not recognise the special characters as coding language.</p>

                <p></p>


                <a href="{{route('xss_secure_front_end')}}"><button class="buttons">View Secured from XSS Front End</button></a>


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


            editor.setSize(null, '410px');

        </script>

    </div>

</body>

</html>