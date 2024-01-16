<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_secure/sql_secure_bn.php');

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

<?php include 'navigation.php'; ?>

    <div class="main">

    <div class="row">

        <div class="editor_column">

        <b>Secured from SQLi (Back-end)</b>
        
        <p>Looking at the back-end we have combined the use of <b>input validation </b> and <b>prepared statements</b>.</p>

        <b>Input Validation via preg_match()</b>

        <p>Take a look at line <b>14</b>, the preg_match() functionality is enclosed in an if function. The regular expression given within the preg_match() function are as follows:</p>

        <p class="code_space">^[a-zA-Z]{8,13}$</p>

        <ol>
            <li><span class="code_space">^</span> Pattern should start at the start of the string.</li>
            <br>
            <li><span class="code_space">[a-zA-Z]</span> Upper and lower case letters are only accepted.</li>
            <br>
            <li><span class="code_space">{8,13}</span> The minimum is 8 and maximum length is 13.</li>
            <br>
            <li><span class="code_space">$</span> Pattern should be applied all the way to the end of the string.</li>
            <br>
        </ol>

        <p>Preg_match() only returns either 1 or 0, 1 being if the user data follows the regular expression and 0 if the user data does not follow the regular expression. </p>

        <p>When both preg_match() functions returns the result of 1, it will then proceed to run the prepared statement.</p>

        <b>Prepared Statement</b>

        <p>Take a look at line 16 and 18.</p>
            
        <p>We first use a prepared statement <b>(Line 16)</b> which is:</p>

        <p class="code_space">SELECT username FROM users WHERE username = ? AND password = ?</p>

        <p>This query will be sent over to the database first, the datbase will recognise that there are placeholders within the query but will not execute the query, it will only do if the user supplied data is provided.</p>

        <p>The user supplied data is first stored in the $username <b>(Line 10)</b> and $password <b>(Line 12)</b> variables. It is then attach to the bind_param function.</p>

        <p>We then use provide the user supplied data using bind_param <b>(Line 18)</b> which is:</p>

        <p class="code_space">$stmt->bind_param("ss", $username, $password);</p>
        
        <p>According to the bind_param syntax: </p>

        <p><span class="code_space">bind_param(<span style="color: red;">"datatype"</span>,<span style="color: red;">$variable1, $variable2, ..., $variableN</span>)</span></p>

        <p>Within our prepared statement, we have <b>2</b> parameters that are <b>username</b> and <b>password</b> and are <b>string</b> types. So within our bind param we have configured:</p>

        <p><span class="code_space">bind_param(<span style="color: red;">"ss"</span>,<span style="color: red;">$username, $password</span>)</span></p>

        <p>The statement is then executed and the results are stored and can be used however you wish, just like a normal query.</p>

        <p><b>Conclusion:</b> From the example above, we have restricted what type and length of chracacters are allowed and potential characters that may cause errors are thrown back to the user, protecting the applicaiton from <b>error-based</b> attacks. We have also used prepared statements so that every data that is placed within the query are taken as a literal value instead of being embedded in the actual query, preventing <b>union-based</b>, <b>boolean-based</b>, <b>time-based</b> and <b>out-of-band</b> attacks.</p>

        <a href="sql_secure_front_end.php"><button class="buttons">View Front-End Code</button></a>

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

        
        editor.setSize(null, '1000px'); 

        function copyTextOne() {
            var copyText = "' UNION SELECT name FROM products --";
            navigator.clipboard.writeText(copyText);
        }

    </script>
    
    </div>

</body>
</html>

