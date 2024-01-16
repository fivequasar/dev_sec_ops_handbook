<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$content = file_get_contents('code_templates/xss_stored/stored_xss_ins_bn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

    fwrite($myfile, $code);

    fclose($myfile);

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

                <h1>Stored Cross Site Scripting</h1>
                <p>We will now explain how Stored XSS works behind the scenes.</p>
                <p>Our main focus will be on line <b>10-11</b>, as well as line <b>13-14</b>. Let's have a breakdown on
                    how the Stored XSS attack works.</p>
                <ol>
                    <li> Form Submission Check and Database Insertion.</li>
                    <ul>
                        <p> Line <b>10-11</b> checks if the form has been submitted using the <b>isset()</b> function
                            on <b>$_POST['message']</b>. This check ensures that the subsequent code executes only when
                            the form has been submitted with data. Overall, it is responsible of handling form
                            submissions. This approach is inadequate as it merely checks for submitted messages without ensuring the integrity. </p>
                        <p> A prepared statement on Line <b>13-14</b> was used to ensure secure insertion of the
                            user-submitted message into the 'comments' table. Anything that is submitted and processed after Line 9 and 10, will then be stored in the database. </p>
                    </ul>
                    <br>
                    <li> Testing how it works</li>
                    <ul>
                        <p>Now, imagine that the attacker has already inserted a script into the form. This script is
                            currently being processed on the backend before it is stored in the database. Insert the
                            following code on line <b>8</b>. Don't forget to enclose the script in
                            <b>single quotes(')</b> at the beginning and end.
                            <br><br><span class="code_space">'&lt;script&gt;alert("Stored XSS
                                Attack");&lt;/script&gt;';</span><button class="buttons" onclick="copyTextTwo()">Copy</button>
                        </p>
                    </ul>
                    <ul>
                        <p> To check the message, you could use echo. Insert the following below the code of the
                            previous example. <br><br><span class="code_space">echo $message </span><button class="buttons" onclick="copyTextOne()">Copy</button></p>
                        <p> After that, run the code. You would notice that you will have the "Stored XSS Attack!" pop
                            up. So what happened? The script is actually already stored inside the database and reflects
                            the output by using the echo.</p>
                    </ul>
                    <br>
                </ol>
                <p>
                    <b>Conclusion:</b> Unvalidated stored XSS allows attackers to save and execute scripts, ensuring
                    persistence and potentially granting access to multiple accounts based on script complexity.
                </p>

                <a href="stored_xss.php"><button class="buttons">Return to front-end</button></a>
                <!--<button class="buttons" onclick="history.back()">Return to front-end</button>-->

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

            editor.setSize(null, '550px');

            function copyTextOne() {
                var copyText = "echo $message;";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextTwo() {

                var copyText = '<sc' + 'ript>alert("Stored XSS Attack!")</scr' + 'ipt>;';
                navigator.clipboard.writeText(copyText);
            }

            function copyTextThree() {
                var copyText = "";
                navigator.clipboard.writeText(copyText);
            }
        </script>
    </div>

</body>

</html>