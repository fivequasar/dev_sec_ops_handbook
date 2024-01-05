<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_blind/sqli_tb_bn.php');

$output = "";

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w") ;
    
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

        <h3 style="margin: 0px 0px 10px 0px;">Time-Based SQLi</h3>

        <p>We'll be focusing on line <b>10</b> and <b>12</b>. </p>
        <p>For line <b>10</b>, the data is stored on the variable $id. This variable should be properly validated, ensuring that (in this case) only numbers are allowed to be handled, any other form of data is ought to be rejected.</p>
        <p>Moving on to line <b>12</b> the $id variable which handles the data is directly embedded in the SQL query, this is considered a bad practice as attackers have direct control and can manipulate the SQL directly before it is sends to the database. </p>
 
        <p>Let's analyse how the earlier attack's work. These are the payload's used (You can copy the payload below and paste it in the value of the <b>$id</b> variable at line <b>10</b>):</p>
        
        <p>The payloads used for this was:</p>
        <ol>

        <li><span class="code_space">1 AND IF(1=1, SLEEP(5), SLEEP(0))</span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>
        <p>When the payload is attached on the SQL query, it will look like this:</p>
        <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink"> = </span><span style="color:green;">1</span> <span style="color:purple;">AND IF</span> ( </span><span style="color:green;">1</span> <span style="color:deeppink;">=</span> <span style="color:green;">1</span>,SLEEP(<span style="color:green;">5</span>), SLEEP(<span style="color:green;">0));</p>
        <p>Let's break down the how the payload is designed. The attacker first adds a valid input in the query.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = <span style="color:red;">1</span> AND IF ( 1 = 1 , SLEEP(5), SLEEP(0));</p>
        <p>Then the AND operator is added. This is so that the IF statement can be appended to the query.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 <span style="color:red;">AND</span> IF ( 1 = 1 , SLEEP(5), SLEEP(0));</p>
        <p>Now, the if statement is used, the syntax of an if statement is:</p>
        <p class="code_space">IF(<span style="color:red;">condition</span>, <span style="color:red;">value_if_true</span>, <span style="color:red;">value_if_false</span>)</p>
        <p>In this case, the attacker request that if the condition 1 = 1 is true, wait for 5 seconds then execute otherwise just execute. An attacker can now attempt to map out the database based on the different queries it provides and the time it takes to execute it.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF(<span style="color:red;">1 = 1</span>, <span style="color:red;">SLEEP(5)</span>, <span style="color:red;">SLEEP(0)</span>)</p>
        <br>
        <li><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='admin'), SLEEP(5), SLEEP(0))</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>
        <p>When the payload is attached on the SQL query, it will look like this:</p>
        <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: purple;">IF</span>(<span style="color: purple;">EXISTS</span>(<span style="color: purple;">SELECT</span> <span style="color: deeppink;">*</span> <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span><span style="color: brown;">'admin'</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">5</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">0</span>))</p>
        <p>SQL will run this command and check that if the username 'admin' exist in the username, if true, wait for 5 seconds else just execute.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">EXISTS (SELECT * FROM users WHERE username ='admin')</span>, <span style="color: red;">SLEEP(5)</span>, <span style="color: red;">SLEEP(0)</span>)</p>
        
        <li><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='administrator'), SLEEP(5), SLEEP(0))</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextThree()">Copy</button></li>
        <p>When the payload is attached on the SQL query, it will look like this:</p>
        <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: purple;">IF</span>(<span style="color: purple;">EXISTS</span>(<span style="color: purple;">SELECT</span> <span style="color: deeppink;">*</span> <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span><span style="color: brown;">'administrator'</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">5</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">0</span>))</p>
        <p>SQL will run this command and check that if the username 'administrator' exist in the username, if true, wait for 5 seconds else just execute.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">EXISTS (SELECT * FROM users WHERE username ='administrator')</span>, <span style="color: red;">SLEEP(5)</span>, <span style="color: red;">SLEEP(0)</span>)</p>
        
        </ol>

        <a href="sqli_blind_time_front_end.php"><button class="buttons">View Time-Based attack front-end</button></a>
        
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

        editor.setSize(null, '1000px'); 


        function copyTextOne() {
            var copyText = "1 AND IF(1=1, SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "1 AND IF(EXISTS(SELECT * FROM users WHERE username ='admin'), SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextThree() {
            var copyText = "1 AND IF(EXISTS(SELECT * FROM users WHERE username ='administrator'), SLEEP(5), SLEEP(0))";
            navigator.clipboard.writeText(copyText);
        }
    </script>

</div>
</body>
</html>

