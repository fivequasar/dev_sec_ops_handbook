<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$content = file_get_contents('code_templates/xss_reflected/reflected_xss_fn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

    fwrite($myfile, $code);

    ob_start();

    include 'code.php';

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
    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="row">

            <div class="editor_column">

                <form method="post">

                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>

                <br>
                <b>Normal Operations</b>
                <p><b>Background: </b>We will be simulating a simple and vulnerable search engine to search for products in the database.</p>
                <p>Let's first find out how the product search engine works. The product search engine in the code allows you to input the product name you want to search for.</p>


                <ol style="padding-left: 20px;">
                    <li>Click <b>Run Code</b>.</li>
                    <br>
                    <li>Copy the text below and paste it into the product search engine.<br><br><span class="code_space">Apples</span><button class="buttons" onclick="copyTextOne()">Copy</button></li>
                    <br>
                    <li>Click <b>Submit</b>. You will be brought to another page to view the results.</li>
                    <br>
                    <li>Take a look at your browser's URL. The result is being reflected onto your browser's URL. </li>
                    <br>
                    <li>Click "Go Back"</li>
                </ol>
                <br>
                <b>Reflected XSS script</b>
                <br>

                <ol style="padding-left: 20px;">

                    <br>
                    <li>Copy the text below and paste it in the product search engine, and click <b>Submit</b>. <br><br><span class="code_space">&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;</span> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>
                    <br>
                    <li>After submitting the script in the product search engine, you will notice a pop-up message box saying "Reflected XSS attack!"</li>
                    <br>
                    <ul>
                        <li>This is one approach to demonstrate that you can execute a JavaScript on a given domain.</li>
                    </ul>
                    <br>
                    <li>Click "Go Back"</li>
                    <br>
                </ol>
                <p>Let's take a look at the backend of the code. Click Below:</p>


                <a href="reflected_xss_bn.php"><button class="buttons">View Back-End Code</button></a>

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


            editor.setSize(null, '450px');

            function copyTextOne() {
                var copyText = "Apples";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextTwo() {
                var copyText = '<sc' + 'ript>alert("XSS attack!");</scr' + 'ipt>';
                navigator.clipboard.writeText(copyText);
            }
        </script>

    </div>
</body>

</html>