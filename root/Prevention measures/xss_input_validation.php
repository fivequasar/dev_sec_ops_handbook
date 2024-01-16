<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/xss_secure/xss_input_validation_bn.php');

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

                <form method="post">

                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>

                <br>

                <b>Using whitelist and preg_match() for input validation</b>

                <p>Let's analyse the syntax that is required for preg_match() to function</p>

                <span class="code_space">preg_match(<span style="color:red">$allowedCharacters</span>, <span style="color:red">$username</span>)</span>

                <br>
                <br>

                <ul>

                    <li>
                        <p><span class="code_space"><span style="color:red">$allowedCharacters</span></span> Is the whitelist that defines the type of characters for the input.</p>
                    </li>

                    <li>
                        <p><span class="code_space"><span style="color:red">$username</span></span> Is the user's input for their username.</p>
                    </li>


                </ul>

                <p>If the whitelist matches the user's input, it will be true. If it dosen't, it will be false. The revelance can be seen in line <b>10</b> and <b>13</b>.</p>

                <p>In the example above, the whitelist is placed within an `if` statement. If the results of the user's input is within the limits of the `$allowedCharacters`, then the results will show "Valid input". Else, it will show "Invalid input".
                    Regular expressions (regex) are used in the syntax to to specify a string of letters that designates a match pattern in text.</p>

                <p>In the syntax, <span class="code_space"><span style="color:red">$allowedCharacters<span style="color:purple"> = '/^[a-z0-9]+$/';</span></span></span> is used. </p>

                <p>Let's breakdown it down:</p>

                <ol>

                    <li>
                        <p><span class="code_space">a-z</span> Only allows lower case letters from 'a' to 'z' in the user's input.</p>
                    </li>
                    <li>
                        <p><span class="code_space">0-9</span> Only allows numbers from '0' to '9' in the user's input.</p>
                    </li>


                </ol>

                <p>A valid input will be like: (you can copy and paste it into line <b>17</b>)</p>

                <span class="code_space">example123</span> <button class="buttons" onclick="copyTextOne()">Copy</button>

                <p>But not:</p>

                <span class="code_space">11Keyboard</span> <button class="buttons" onclick="copyTextTwo()">Copy</button>

                <p>Feel free to try other inputs if you thought of one.</p>
                <br>

                <p>You can also try to change the regex pattern in line <b>6</b> to other patterns.</p>

                <p>Below are some other examples.</p>

                <span class="code_space">'/^[a-zA-Z0-9_]+$/';</span> <button class="buttons" onclick="copyTextThree()">Copy</button>
                <br>
                <br>
                <span class="code_space">'/^_[A-Z0-9]5$/';</span> <button class="buttons" onclick="copyTextFour()">Copy</button>


                <p>For more information on regex please go to: <a href="https://regexr.com/">https://regexr.com/</a></p>

                <p><b>Conclusion: </b>Using whitelist to define the characters allowed for the user's input acts as a barrier, and is the first line of defense. It should always be the baseline of security, and should be used together with multiple layers of security measures to ensure robust protection.</p>

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

            function copyTextOne() {
                var copyText = "example123";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextTwo() {
                var copyText = "11Keyboard";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextThree() {
                var copyText = "'/^[a-zA-Z0-9_]+$/';";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextFour() {
                var copyText = "'/^_[A-Z0-9]5$/';";
                navigator.clipboard.writeText(copyText);
            }
        </script>

    </div>

</body>

</html>