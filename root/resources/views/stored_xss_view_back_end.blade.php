<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_stored/stored_xss_bn.php');

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

    <h3 style="margin-top: 0px;">Stored XSS (View Message Function) Back End</h3>

    <form method="post">
        @csrf
        <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
        <input type="submit" value="Run Code >" class="buttons">
    
    </form>

    <p>The code presented above is responsible for displaying the contents of all messages within the database.</p>

    <p>We'll be focusing on line <b>17</b> to line <b>20</b>, when displaying any sort of content coming from the database, encoding should be applied prior to it being displayed to a page.</p>

    <p>When the website displays <span class="code_space" style="padding: 2px 10px 2px 10px;">&lt;script&gt;alert('XSS')&lt;/script&gt;</span> extracted from the database without any encoding, the browser will interpret and execute it as a JavaScript script. </p>





        <a href="{{route('stored_front_end')}}"><button class="buttons">View Stored XSS Front End</button></a>
    </div>

    <div class="output_column">


    <?php echo $output; ?> 



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

        editor.setSize(null, '400px'); 

        function copyTextOne() {
            var copyText = "<sc" + "ript>alert('XSS')</scr" + "ipt>";
            navigator.clipboard.writeText(copyText);
        }


        function copyTextTwo() {
            var copyText = "' UNION SELECT name FROM products --  ";
            navigator.clipboard.writeText(copyText);
        }
    </script>

</body>
</html>

