<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$code = file_get_contents('code_templates/sqli_secure/prepared_bn.php');

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

        <form method="post">
            @csrf
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Using prepared statements</b>



<p>There are two crucial factors for prepared statements to work</p>
        



                <p>In the SQL query, all parameters that require user input are now replaced with question marks (Line <b>14</b>) This query will be first sent to the database, the database will then recognise that there are placeholders within the statement and will only execute when the user data is inserted.</p>



                <p>The bind_param function is used to hold user data and is responsible for combining the user data with the sql query. (Line <b>16</b>) In the event that user-supplied variables within the bind_params are set, it will send this data over to the database and will be combined with the prepared statement, the query will only then be executed within the database. </p>
                <p>Let's analyse the bind_param syntax:</p>
                
                <p><span class="code_space">bind_param(<span style="color: red;">"datatype"</span>,<span style="color: red;">$variable1, $variable2, ..., $variableN</span>)</span></p>

                <ol>

                    <br>
                    <li><span class="code_space"><span style="color:red">datatype</span></span></li>
                    <p>Depending on the number of variables you have, you need to specify what type of variable it is. From our example we only have two user inputs that is <b>username</b> and <b>password</b>, so thus we will expect two strings. And thus the following is set:</p>
                    <p><span class="code_space">bind_param(<span style="color: red;">"ss"</span>,$variable1, $variable2, ..., $variableN)</span></p>
                    <br>
                    <li><span class="code_space"><span style="color:red">variables</span></span></li>
                    <p>This is where the actual user data is kept. The number of and the arrangement of the variables should be according to the placeholder within the query you have provided within the prepared statement. In our query, we have <b>2</b> place holders, the first placeholder is <b>username</b> and then the <b>password</b>. And thus the following is set:</p>
                    <p><span class="code_space">bind_param("ss",<span style="color: red;">$username, $password</span>)</span></p>
                    
                </ol>
<br>
<p style="margin-top: 0px;">We then proceed to execute the code (Line <b>18</b>)</p>
        <span class="code_space">$stmt->execute();</span>

        <br>
        <br>

<p>And store the results in a variable (Line <b>20</b>)</p>
        <span class="code_space">$result = $stmt->get_result();</span>


        <br>
        <br>

        <p><b>Conclusion: </b>By using prepared statements, it stops attackers from manipulating the query as both the query and data are sent to the database seperately.</p>

        <p>When an attacker performs a union-based attack on the query that is unprepared:</p>
        <div class="code_space">SELECT username FROM users WHERE username = '<span style="color: red;">' UNION SELECT name FROM products --</span> AND password = '?' </div>

        <p>When an attacker performs a union-based attack on the query that is prepared:</p>
        <div class="code_space">SELECT username FROM users WHERE username = '<span style="color: red;">' UNION SELECT name FROM products --</span>' AND password = '?' </div>
        <p>The UNION payload will be taken as a literal string value and will actively search for the username that is (Feel free to paste the following payload for the value of the $username variable):</p>
        <span class="code_space"><span style="color: red;">' UNION SELECT name FROM products --</span></span>  <button class="buttons" onclick="copyTextOne()">Copy</button>


        

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

        
        editor.setSize(null, '500px'); 

        function copyTextOne() {
            var copyText = "' UNION SELECT name FROM products --";
            navigator.clipboard.writeText(copyText);
        }

    </script>
    
    </div>

</body>
</html>

