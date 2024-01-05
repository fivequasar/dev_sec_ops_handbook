<?php

$server_var = 'localhost';
$username_var = 'sandbox_user';
$password_var = 'password';
$db_var = 'sample_db';

$code = file_get_contents('code_templates/sqli_in_band/sqli_ib_bn.php');

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

        <h3 style="margin: 0px;">Union-Based Injection Back End</h3>
        <p>Let's first analyse line <b>10</b> and <b>12</b>. Notice that the variables for username and passwords are not properly validated and that it allows malicious text to be added like the ones we did earlier. </p>

        <p>Now look at line <b>14</b>. Notice that the variables are directly embedded within the SQL query. This is extremely dangerous, as the query can be manipulated directly, thus allowing attackers to use this query as a proxy to find out more about your database through using SQL commands that was shown earlier.  </p>

        <p>Let's breakdown how the earlier Union-based attack works. (You can copy the payload below and paste it in the value of the <b style="font-family: 'Courier New', Courier, monospace">$username</b> variable at line <b>10</b>)</p>

        <p>This is the attacker's input for the username </p>
        <p><span class="code_space">' UNION SELECT name FROM products -- </span>&nbsp;<button class="buttons" onclick="copyTextOne()">Copy</button></p>
        
        <p>When replaced with the username variable within the SQL Query, it will look like this:</p>
        <p class="code_space"><span style="color:purple;">SELECT</span> username <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span> <span style="color:brown;">''</span> <span style="color:purple;">UNION SELECT</span> name <span style="color:purple;">FROM</span> products <span style="color:#CD7F32;">-- ' AND password = '$password';</span></p>
        <p>The first character of the attacker's query is a quotation, this is so that the username command will stil run but SQL will see it as an empty value</p>
        <p class="code_space">SELECT username FROM users WHERE username = <span style="color: red;">''</span> UNION SELECT name FROM products --  ' AND password = '$password';</span></p>

        <p>It then proceeds to perform a union-based attack, for this attack it needs to fit two conditions:</p>

        <ol>
            <li>The original SELECT statement needs to have the same number of columns as the UNION statement.</li>
            <br>
            <li>The UNION column must contain the same data type as the original SELECT statement.</li>
        </ol>

        <p>Looking at the original query, it currently only pulls a single column called <span style="font-family: 'Courier New', Courier, monospace;">username</span> from the <span style="font-family: 'Courier New', Courier, monospace;">users</span> table. Assuming that the attacker knows the name of the other table, it then proceeds to pull a single column called <span style="font-family: 'Courier New', Courier, monospace;">name</span> from the <span style="font-family: 'Courier New', Courier, monospace;">products</span> table</p>
        <p class="code_space">SELECT <span style="color:red;">username</span> FROM <span style="color:red;">users</span> WHERE username = '' UNION SELECT <span style="color:red;">name</span> FROM <span style="color:red;">products</span> -- ' AND password = '$password';</p>
        <p>The attacker then finally comments out the rest of the query using <span style="font-family: 'Courier New', Courier, monospace;">--</span>. This way, the SQL statement will completely ignore the password command, and just run the UNION command instead.  </p>
        <p class="code_space">SELECT username FROM users WHERE username = '' UNION SELECT name FROM products <span style="color:red;"> -- ' AND password = '$password';</span></p>
        <p>And thus, this is what the SQL sees and runs:</p> 
        <p class="code_space"><span style="color:purple;">SELECT</span> username <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username <span style="color:deeppink">=</span> <span style="color:brown;">''</span> <span style="color:purple;">UNION SELECT</span> name <span style="color:purple;">FROM</span> products</p>

        <a href="sqli_in_band_union_front_end.php"><button class="buttons">View Union-based Front-end</button></a>
    </div>

    <div class="output_column">
 
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
            var copyText = "' UNION SELECT name FROM products --  ";
            navigator.clipboard.writeText(copyText);
        }

    </script>

</div>
</body>
</html>

