<?php
$content = file_get_contents('code_templates/xss_dom/xss_dom_bn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w");

    fwrite($myfile, $code);

    ob_start();

    @include("code.php");

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

        <div>

        </div>

        <div class="row">

            <div class="editor_column">
                <h2>Why is this considered a DOM-based XSS attack?</h2>
                <b>DOM-based Attack</b>
                <p>In this backend showcase, the <b>document.URL</b> will be manually modified and stored into the variable <b>"url"</b> on line <b>14</b> for demonstration purposes. The actual lines of vulnerable codes in the backend are in lines <b>22</b> to <b>24</b>.</p>
                <b>Testing if a component is vulnerable to XSS</b>
                <p>The input used earlier in the front end was:</p>

                <ol>
                    <li><span class="code_space">Test</span><button class="buttons" onclick="copyTextOne()">Copy</button></li>

                    <p>When this input replaces the current username, <b>"Isaiah"</b> in line <b>14</b>, the URL of the webpage would look like this:</p>

                    <p><span class="code_space">http://www.example.com?username=<span style="color:red;">Test</span></span></p>

                    <li>If you click Run Code, it will now return "Hello Test!" instead</li>

                </ol>
                <br>
                <b>Let's break down how this works line by line:</b>
                <ol>

                    <p>On line <b>15</b>, the script extracts a username from the URL using "<b>url.indexOf("username=") + 9</b>" to find the position of "<b>username=</b>" in the URL and then adds 9 to get the starting index of the actual username.</p>

                    <p>On line <b>16</b>, the substring method is used to extract a portion of the URL starting from the position stored in the username variable. The unescape function is then used to decode any encoded characters in the extracted portion, and the result is stored in the variable <b>user</b></p>

                    <p>On line <b>17</b>, the script uses <b>document.write</b> to dynamically update the content of the page by writing <b>"Hello, "</b> followed by the <b>user's input.</b></p>
                </ol>
                <br>
                <b>Inputting a malicious script</b>
                <p>The malicious script used earlier was:</p>
                <ol>
                    <li><span class="code_space">&lt;script&gt;alert('XSS');&lt;/script&gt;</span><button class="buttons" onclick="copyTextTwo()">Copy</button></li>

                    <p>Now when this script replaces the <b>"Test"</b> username, the URL of the webpage would look like this:</p>

                    <p><span class="code_space" style="margin-top:5px;">http://www.example.com?username=<span style="color: red">&lt;script&gt;alert('XSS');&lt;/script&gt;</span></p>

                    <li>This time if you Run Code, it will return an alert instead because the script will be executed</li>
                </ol>
                <br>
                <b>Why does the malicious script get executed?</b>
                <ol>

                    <p>Since the webpage uses <b>document.write</b> on line <b>17</b>, it does not just display the user input; it directly incorporates it into the page content. This means that if an attacker injects a script in the username parameter, that script will be executed in the context of the page. As <b>"document.write"</b> is not a secure method of displaying user input back into the webpage</p>


                </ol>

                <b>Sources and Sinks</b>
                <ol>
                    <li>Source: <b>document.URL</b></li>

                    <p>The source is where user-controlled data enters the application. In this case, <b>document.URL</b> represents the current URL of the document, and if the application uses this data without proper validation or encoding, it can become a source of user-influenced content.</p>

                    <li>Sink: <b>document.write</b></li>

                    <p>The sink is where user-controlled data is incorporated into the DOM without proper validation or encoding. In this case, document.write is a potential sink because it can be used to dynamically write content to the document, and if user-controlled data is directly written without proper validation, it can lead to XSS vulnerabilities.</p>

                </ol>
                <p><b>Conclusion:</b> Both <b>document.URL</b> and <b>document.write</b> are used without proper sanitisation or validation. An attacker will be able to manipulate the URL parameters to inject malicious scripts, and since these scripts are written using document.write, they will execute within the context of the page, leading to a XSS attack.</p>


                <button class="buttons" onclick="history.back()">Return</button>


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

            <script>
                var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: "application/x-httpd-php",
                    indentUnit: 4,
                    indentWithTabs: true,
                    theme: "ayu-dark"
                });

                editor.setSize(null, '100%');

                function copyTextOne() {
                    var copyText = "Test";
                    navigator.clipboard.writeText(copyText);
                }

                function copyTextTwo() {
                    var copyText = "<sc\" + \"ript>alert('XSS');</scr\" + \"ipt>";
                    navigator.clipboard.writeText(copyText);
                }
            </script>



        </div>
</body>

</html>