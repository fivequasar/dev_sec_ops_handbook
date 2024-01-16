<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/xss_secure/encoding_bn.php');

$output = "";

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

    fwrite($myfile, $code);

    ob_start();

    include 'code.php';

    $output = ob_get_contents();

    ob_end_clean();

    unlink("code.php");
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

    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="row">

            <div class="editor_column">

                <h3 style="margin: 0px 10px 0px 0px;">HTML Encoding</h3>
                <br>

                <form method="post">

                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>

                <br>

                <b>Using htmlspecialchars() for encoding</b>

                <p>Let's analyse the syntax that is required for htmlspecialchars() to function</p>

                <span class="code_space">htmlspecialchars(<span style="color:red">input</span>,<span style="color:red">flags</span>)</span>

                <br>
                <br>

                <ul>

                    <li>
                        <p><span class="code_space"><span style="color:red">input</span></span> The text you want to encode <b>(required)</b> </p>
                    </li>
                    <li>
                        <p><span class="code_space"><span style="color:red">flags</span></span> If you want to specify your encoding <b>(optional)</b> </p>
                    </li>

                </ul>

                <p>There are other parameters which are optional but for now we will be focusing on these 2</p>

                <p>The <b>ENT_QUOTES</b> in the second parameter basically means that the function will also encode single and double quotes. There are other type of flags but this is the most common one to prevent XSS attacks</p>

                <p>Copy the script below and paste it in the <b>$username</b> variable on line <b>2</b> and Run Code:</p>

                <p><span class="code_space">&lt;script&gt;alert('XSS');&lt;/script&gt;</span><button class="buttons" onclick="copyTextOne()">Copy</button></p>


                <p>The output will return the script string but because the special characters are encoded into their HTML entities on the server side, they are are now treated as plain text instead of executable scripts on the client side</p>

                <p>If you want to see what the output would be without the encoding:</p>
                <ol>
                    <li><p>Replace the <b>$encodedUsername</b> variable on line <b>4</b> with the <b>$username</b> variable and run the code again with the script that was used earlier</p></li>
                    <li><p>Now the script will be executed because the special characters are not being encoded to their HTML entities</p></li>
                </ol>
                <p>Now the script will be executed because the special characters are not being encoded to their HTML entities</p>


                <p>For more information on encoding html special characters please go to: <a href="https://www.php.net/manual/en/function.htmlspecialchars.php">https://www.php.net/manual/en/function.htmlspecialchars.php/</a></p>

                <p><b>Conclusion: </b>htmlspecialchars() translates special characters to HTML entities, preventing them from being interpreted as code and improving security by reducing the danger of cross-site scripting (XSS) attacks.</p>



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


            editor.setSize(null, '130px');

            function copyTextOne() {
                var copyText = "<sc" + "ript>alert('XSS')</scr" + "ipt>";
                navigator.clipboard.writeText(copyText);
            }

        </script>

    </div>

</body>

</html>