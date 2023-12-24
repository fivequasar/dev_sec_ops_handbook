<?php
$content = file_get_contents('code_templates/front_end/sqli_b_fn_bn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w") ;
    
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
    <link rel="stylesheet" href="/v/css/style.css">
    <link rel="stylesheet" href="/v/codemirror/codemirror.css">
    <link rel="stylesheet" href="/v/codemirror/ayu-dark.css">
    <script src="/v/codemirror/codemirror.js"></script>
    <script src="/v/codemirror/matchbrackets.js"></script>
    <script src="/v/codemirror/htmlmixed.js"></script>
    <script src="/v/codemirror/xml.js"></script>
    <script src="/v/codemirror/javascript.js"></script>
    <script src="/v/codemirror/css.js"></script>
    <script src="/v/codemirror/clike.js"></script>
    <script src="/v/codemirror/php.js"></script>
</head>


<body>

<div class="vertical-menu">

    <a href="/v/index.php">Home</a>
    <a href="/v/sqli_home.php" >SQL Injection</a>
    <a href="/v/xss_home.php">XSS</a>

</div>

<div class="main">

<div>

    <?php echo $output; ?>

</div>

    <div class="row">
        
        <div class="editor_column">
        <p>We'll be focusing on line <b>10</b> and <b>12</b>. </p>
        <p>For line <b>10</b>, the data is stored on the variable $id. This variable should be properly sanitized, ensuring that (in this case) only numbers are allowed to be handled, any other form of data is ought to be rejected.</p>
        <p>Moving on to line <b>12</b> the $id variable which handles the data is directly embedded in the SQL query, this is considered a bad practice as it allows attackers to perform Boolean/Time-based attacks. </p>

        <p>Let's analyse how the earlier attack's work. These are the payload's used:</p>
        
        <b>Boolean Based Attack</b>

        <p></p>

        <ol>

            <li><span class="code_space">1 AND 1 = 2</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, address <span style="color:purple;">FROM</span> sample_tb <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">2</span>;</span></p>
                <p>When the SQL receives the value AND 1 = 2, it will  return false as 1 does not equate to 2, which will return no entries within the WHERE clause.</p>

            <br>

            <li><span class="code_space">1 AND 1 = 1</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, address <span style="color:purple;">FROM</span> sample_tb <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> AND <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">1</span>;</span></p>
                <p>When the SQL receives the value AND 1 = 1, it will return true as 1 equates to 1, it will return the specified entry within the WHERE clause.</p>

            <br>

            <li><span class="code_space">1 OR 1 = 1</span></li>

                <p>When the payload is attached on the SQL query, it will look like this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, address <span style="color:purple;">FROM</span> sample_tb <span style="color:purple;">WHERE</span> id <span style="color:deeppink">=</span> <span style="color:green;">1</span> OR <span style="color:green;">1</span> <span style="color:deeppink">=</span> <span style="color:green;">1</span>;</span></p>

                <p>Which is equivalent to this:</p>
                <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, address <span style="color:purple;">FROM</span> sample_tb <span style="color:purple;">WHERE</span><span style="color:darkblue"> TRUE</span>;</span></p>
                <p>When the SQL receives the value OR 1 = 1, it will always return true and return the entire entry of the table, eliminating the WHERE clause completely.</p>

        </ol>

        <br>

        <b>Time Based Attack</b>

        <ol>

        <p>The paylod used for this was:</p>

        <p><span class="code_space">1 AND IF(1=1, SLEEP(5), SLEEP(0))</span></p>

        <p>When the payload is attached on the SQL query, it will look like this:</p>
        <p><span class="code_space"><span style="color:purple;">SELECT</span> id, name, address <span style="color:purple;">FROM</span> sample_tb <span style="color:purple;">WHERE</span> id <span style="color:deeppink"> = </span><span style="color:green;">1</span> <span style="color:purple;">AND IF</span> ( </span></p>
        <p><span class="code_space"><span style="color:green;">1</span> <span style="color:deeppink;">=</span> <span style="color:green;">1</span>,SLEEP(<span style="color:green;">5</span>), SLEEP(<span style="color:green;">0</span>));</span></p>
        <p>This is basically telling the query that, if 1 = 1 is true, then wait for 5 seconds otherwise just execute. An attacker can determined if the paramter is vulnerable to SQLi by the time it takes to execute the command.</p>

        </ol>

        
        </div>

        <div class="output_column code_font">

            <form method="post">

                <textarea id="code" name="code"><?php echo $code; ?></textarea>

                <br>

                <input type="submit" value="Run Code >" class="buttons">

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

        editor.setSize(null, '1150px'); 
    </script>

</div>
</body>
</html>

