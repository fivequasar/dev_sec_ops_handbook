<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/xss_secure/secure_xss_ins_bn.php');

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

                <b>XSS Secure Submit Function using Input Validation.</b>

                <p></p>

                <p>Take a look at line <b>20</b> you will notice that we have a <b style="font-family:'Courier New', Courier, monospace">preg_match()</b> function in place. Depending on the context of your function within the website, the regular expression that you have set should be what you will expect coming from the user. In this case, the regular expression are as of the following:</p>

                <p class="code_space">^[a-zA-Z]$</p>

                <ol>
                    <li><span class="code_space">^</span> Pattern should start at the start of the string.</li>
                    <br>
                    <li><span class="code_space">[a-zA-Z]</span> Upper and lower case letters are only accepted.</li>
                    <br>
                    <li><span class="code_space">$</span> Pattern should be applied all the way to the end of the string.</li>
                    <br>
                </ol>

                <p>If when the <b style="font-family:'Courier New', Courier, monospace">preg_match()</b> detects that the user-supplied input is any character but the specified expression, it will proceed to give back the message "Invalid Input" or else it will run the prepared statement to submit the message to the database.</p>

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


            editor.setSize(null, '600px');


        </script>

    </div>

</body>

</html>