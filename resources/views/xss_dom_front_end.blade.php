<?php
$code = file_get_contents('code_templates/xss_dom/xss_dom_fn.php');

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

                <h3 style="margin: 0px 10px 0px 0px;">DOM-Based XSS Sandbox</h3>
                <br>

                <form method="post">
                    @csrf
                    <textarea id="code" name="code"><?php echo $code; ?></textarea>
                    <br>
                    <input type="submit" value="Run Code >" class="buttons">
                </form>

                <br>
                <b>Normal Operations</b>
                <p><b>Background: </b> In this sandbox exercise, assume that you are already logged in as a user in this website and the goal is for you
                    to execute an alert message successfully by manipulating the DOM of the webpage.</p>

                <b>DOM-based XSS Attack</b>

                <ol>
                    <li>Click <b>Run Code</b></li>
                    <br>
                    <li>Go to the profile page</li>
                    <br>
                    <li>Notice that the webpage greets you with a "Hello" message</li>
                </ol>
                <b>Browser URL displaying the current user's username</b>
                <ol>
                    <li>Since the user's username is displayed in the URL:</li>

                    <p>Copy the test username below and paste it on the URL to replace the current username "Isaiah"</p>
                    <p><span class="code_space">Test</span><button class="buttons" onclick="copyTextOne()">Copy</button></p>

                    <li>The content of the webpage changes and now the Hello message greets the username "Test" instead of "Isaiah"</li>
                    <br>
                    <li>Now the attackers knows it is possible for them to manipulate the URL of the webpage and it returns the manipulated element back to the webpage. This suggests that the URL parameter does not have proper security implementations thus allowing the attacker to elevate their attacker by inputting a malicious script into the <b>username parameter</b></li>
                    <br>
                    <li>Copy the alert script below. Replace the "Test" username with the script and click on the "Go" button</li>
                    <p><span class="code_space">&lt;script&gt;alert('XSS');&lt;/script&gt;</span><button class="buttons" onclick="copyTextTwo()">Copy</button></p>

                </ol>


                <p>Now the page should return an alert which says "XSS" and this could lead to a greater attack by the attacker</p>
                <p>Let's analyse the back-end code and understand its vulnerability. Click below:</p>

                <a href="{{route('dom_back_end')}}"><button class="buttons">View DOM XSS attack Back End</button></a>


            </div>


            <div class="output_column code_font">

                <iframe srcdoc="<?php echo htmlspecialchars($output); ?>" frameborder="0" width="100%" height="100%"></iframe>

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

            editor.setSize(null, "429px");

            function copyTextOne() {
                var copyText = "Test";
                navigator.clipboard.writeText(copyText);
            }

            function copyTextTwo() {
                var copyText = "<sc" + "ript>alert('XSS')</scr" + "ipt>";
                navigator.clipboard.writeText(copyText);
            }
        </script>

    </div>

</body>

</html>