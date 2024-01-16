<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$content = file_get_contents('code_templates/xss_reflected/reflected_xss_bn_bn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

    fwrite($myfile, $code);

    ob_start();

    include("code.php");

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

                <h3 style="margin: 0px 0px 10px 0px;">Reflected XSS</h3>

                <p>Let's analyse the vulnerabilities of this code.</p>

                <ol>
                    <li><span class="code_space"> <span style="color:crimson;">$name</span> = '';</span></li>


                    <p>In line <b>10</b>, the <span style="color:crimson;">`$name` </span>variable is not properly sanitized before being echoed.</p>


                    <p> This causes lack of input sanitization. </p>
                    <p>If the input contains malicious script code, it will be executed when the page is rendered, potentially leading to a Reflected XSS attack.</li>


                        <br>
                        <li><span class="code_space"><span style="color:purple;">&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;</span></span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>

                    <p>You can try to copy and paste the script above, into line <b>10</b> to simulate changing the back-end code.
                    </p>

                    <p> Copying and pasting it into line <b>10</b> will look like this:</p>

                    <span class="code_space"> <span style="color:crimson;">$name </span>= <span style="color:purple;">'&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;';</span></span></li>
                    <p>When you run the code, your browser will reload and a message box will pop up, saying "Reflected XSS attack!" </p>


                </ol>
                <p><b>Conclusion: </b>Unsanitized or not validating user's input before echoing it into HTML will allow attackers to insert JavaScript or malicious codes unto websites and will get reflected to a user's website; causing transmitting private data or disguising as the user to perform other malicious activity and many more.</p>

                <a href="reflected_xss.php"><button class="buttons">View Reflected XSS attack front-end</button></a>

            </div>

            <div class="output_column code_font">


                <div class="output_result">

                    <?php echo $output; ?>

                </div>

                <br>
                <form method="post">
                    <input type="submit" value="Run Code >" class="buttons">
                    <br>
                    <br>
                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                </form>

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

            editor.setSize(null, '1450px');

            function copyTextOne() {
                var copyText = '<sc' + 'ript>alert("Reflected XSS attack!");</scr' + 'ipt>';
                navigator.clipboard.writeText(copyText);
            }
        </script>

    </div>
</body>

</html>