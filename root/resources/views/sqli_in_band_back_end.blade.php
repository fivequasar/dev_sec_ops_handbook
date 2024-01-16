<?php


$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

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

@include('layouts.navigation')

<div class="main">

    <div class="row">

        <div class="editor_column">
        
        <h3 style="margin: 0px;">Error-Based SQLi Back End</h3>
    
        <form method="post">
            @csrf
                <br>
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                
                <input type="submit" value="Run Code >" class="buttons">
    
        </form>
        <p>Let's first analyse line <b>10</b> and <b>12</b>. Notice that the variables for username and passwords are not properly validated and that the errors are not caught properly.</p>
            <p>When the values that needs to be inserted to the query is not validated properly, MYSQL will catch the error instead of the code catching the error, revealing information regarding the DBMS </p>
    
            <p>Now look at line <b>14</b>. Notice that the variables are directly embbeded within the SQL query. This is extremely dangerous, as the query can be manipulated directly, therefore allowing attackers to cause errors on purpose as shown earlier.</p>
            <p>Let's breakdown how the earlier boolean attack works. (You can copy the payload below and paste it in the value of the <b style="font-family: 'Courier New', Courier, monospace">$username</b> variable at line <b>10</b>)</p>
    
            <p>Let's analyse the earlier given payload:</p>
    
            <p><span class="code_space">'</span>&nbsp;<button class="buttons" onclick="copyTextOne()">Copy</button></p>
    
            <p>When replaced with the <b style="font-family: 'Courier New', Courier, monospace">$username</b> variable within the SQL query, the query will look like this:</p>
    
            <div class="code_space"><span style="color: purple;">SELECT</span> username <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span> <span style="color: brown;">'<b style="color: red;">'</b> AND password </span><span style="color: deeppink;">=</span> <span style="color: brown;">'<span style="color: black;">$password</span>'</span>;</div> 
       
            <p>This causes the query to recognise that the <span style="font-family: 'Courier';">'' AND password = '</span>  as a value and completely breaks the query as the AND operator is part of that value. This is why the error seen earlier contains <span style="font-family: 'Courier';">'' AND password = '</span>.</p>
    
    
            <a href="{{route('in_band_front_end')}}"><button class="buttons">View Error-based Front-end</button></a>
        </div>
    
        <div class="output_column">
    
        <?php echo $output; ?> 
    
        <br>
    
    
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
    
            editor.setSize(null, '500px'); 
    
            function copyTextOne() {
                var copyText = "'";
                navigator.clipboard.writeText(copyText);
            }
    
        </script>
    
    </div>


