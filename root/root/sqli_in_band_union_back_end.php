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

       <b>The UNION Operator</b>
       
       <p>UNION statements combine two or more SELECT statements into a single entry. For a union operator to work it needs to fit two conditions:</p>
       
       <ol>
       <li>Both the number of columns in the original SELECT and UNION needs to be the same.</li>

       <li>It needs to be the same data type.</li>
       </ol>
       
       <b>Finding out the number of columns using ORDER BY.</b>
       <p>Based on the attacks demonstrated on the front end, we first find out how many columns are there within the query by using ORDER BY. Normally, the ORDER BY operator is used to arrange a column by either it's ascending or descending order, by default it would be ascending.</p>

       <div style="padding: 20px; background-color:#e2e2e2;; border-radius: 10px;">

        <b style="margin-top: 0px;">An example</b>

        <button class="buttons" id="readMore" onclick="toggle()" style="display: inline-block;">Read More</button>

        <div id="road">

        <br>
        <br>

       <span class="code_space">SELECT <span style="color: red;">id</span>, name FROM products ORDER BY <span style="color: red;">1</span></span>

        <p>As the id is an interger type, this will sort the id column within the database from lowest to highest. (1, 2, 3....)</p>

        <br>

        <span class="code_space">SELECT id, <span style="color: red;">name</span> FROM products ORDER BY <span style="color: red;">2</span></span>

        <p>As the name is a string type, this will sort the id column within the database from the starting letter from A to Z.</p>

        <br>

        <span class="code_space">SELECT id, name FROM products ORDER BY <span style="color: red;">3</span></span>

        <p style="margin-bottom: 0px;">It will produce an error as row 3 does not exist within the query, that's how an attacker knows how many columns there are by doing it this way.</p>

        <br>
        <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

        </div>

       </div>



       <p>The payloads we used earlier are:</p>

       <ol>

       <li><p><span class="code_space" style="margin-right: 10px;">' ORDER BY 1-- </span> <button class="buttons" onclick="copyTextOne()">Copy</button></p></li>

        <p>When replaced with the <b style="font-family: 'Courier New', Courier, monospace;">$username</b> variable, the query will now look like:</p>

        <div class="code_space">SELECT <span style="color: red;">username</span> FROM users WHERE username = '' ORDER BY <span style="color: red;">1</span> -- ' AND password = '$password';</div>

        <p>Based on the commands we have provided in the query, it first closes of the quotation, then it proceeds to use the ORDER BY 1 operator followed by commenting out the rest of the query. This calls for the first column within the original select statement.</p>

        
        <li><p><span class="code_space" style="margin-right: 10px;">' ORDER BY 2-- </span> <button class="buttons" onclick="copyTextOne()">Copy</button></p></li>

        <p>When replaced with the <b style="font-family: 'Courier New', Courier, monospace;">$username</b> variable, the query will now look like:</p>

        <div class="code_space">SELECT username FROM users WHERE username = '' ORDER BY <span style="color: red;">2</span> -- ' AND password = '$password';</div>

        <p>Based on the commands we have provided in the query, it first closes of the quotation, then it proceeds to use the ORDER BY 2 operator followed by commenting out the rest of the query. This calls for the second column within the original select statement, but the second column does not exist and thus an error will be reflected.</p>

        

        
       </ol>

       <b>Finding out the datatypes of the columns</b>
       <p>Next is to know is this single column willing to take in data that is strings by using a UNION statement. (With the exception of MySQL)</p>

       <div style="padding: 20px; background-color:#e2e2e2;; border-radius: 10px;">

       

        <b style="margin-top: 0px;">An example</b> 

        <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>

        <div id="roadTwo">

        <p>Say we have a query like this:</p>

        <span class="code_space">SELECT id, name FROM products WHERE id = '';</span>

        <p>Based on this, we are able to know that there are two columns but with two different data types, that is id (type int) and name (type varchar). In reality, the query won't be easily shown like this, but for demostration purposes we will do it this way.</p>

        <p>The attacker then adds the following payload:</p>

        <span class="code_space">' UNION SELECT 'a',NULL -- </span>

        <p>Thus, the query now looks like:</p>

        <div class="code_space">SELECT <span style="color: red;">id</span>, name FROM products WHERE id = '' UNION SELECT <span style="color: red;">'a'</span>,NULL -- ';</div> 

        <p>As there are two columns within the original SELECT statement, the attacker proceeds to perform a UNION command with it's own two columns, but if you noticed, we don't specify other tables, we are inserting values 'a' and NULL within the original SELECT statement.  </p>
        
        <p>So the string 'a' will be appended to the column id, while the NULL value (essentially ignores the second column name) will be appended to the column name. Due to the fact that the column id is strictly intergers, and we are appending the string 'a' to it. It will thus reflect the following error:</p>

        <div class="code_space">Conversion failed when converting the varchar value 'a' to data type int.</div>

        <p>This tell us that the first column within the string is not compatible for string values.</p>

        <p>The attacker then adds the following payload:</p>

        <span class="code_space">' UNION SELECT NULL,'a'--  </span>

        <p>Thus, the query now looks like:</p>

        <div class="code_space">SELECT id, <span style="color: red;">name</span> FROM products WHERE id = '' UNION SELECT NULL,<span style="color: red;">'a'</span>  -- ';</div>

        <p>So now the NULL value (essentially ignores the first column id) will be appended to the column id, while the string 'a' value will be appended to the column name. It will not reflect back any errors, as the string 'a' is compatible with the column name.</p>

        <p>This essentially tells the attacker that the second column, and only the second column name is a string type</p>


       </div>

       <button class="buttons" id="readLessTwo" onclick="toggleTwoOff()" style="display: none;">Read Less</button>
</div>

       <p>The payloads we used earlier are:</p>

       <p><span class="code_space" style="margin-right: 10px;">' UNION SELECT 'a' -- </span> <button class="buttons" onclick="copyTextFour()">Copy</button></p>

       <p>As we know, we have only one column within the query, so when replaced with the variable <b style="font-family: 'Courier New', Courier, monospace">$username</b>, it will look like.</p>

       <div class="code_space"><span style="color: purple;">SELECT</span> username <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span> <span style="color: brown;">''</span> <span style="color: purple;">UNION</span> <span style="color: purple;">SELECT</span> <span style="color: brown;">'a'</span> <span style="color: brown;">-- ' AND password = '$password';</span></div>

       <p>It is essentialy inserting the string 'a' in the username column, to test if this column is able to accept string values. When placed in our login component it does not reflect any errors, instead it will just display "Login Failed".</p>

       <p>So thus now we know that our query only contains a <b>single</b> column and that column is a <b>string</b> type</p>

       <b>Performing Union-Based SQLi</b>

       <p>Now that we know somewhat how the structure looks like we can now perform the following:</p>

       <ol>
        <li><p><span class="code_space" style="margin-right: 10px;">' UNION SELECT current_user() -- </span> <button class="buttons" onclick="copyTextFive()">Copy</button></p></li>

        <p>When replaced with the <b style="font-family: 'Courier New', Courier, monospace">$username</b> variable it looks like this:</p>

        <div class="code_space"><span style="color: purple;">SELECT</span> username <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span> <span style="color: brown;">''</span><span style="color: purple;">UNION</span> <span style="color: purple;">SELECT</span> <span style="color: purple;">current_user()</span><span style="color: brown;">-- ' AND password = '$password';</span></div>

        <p>The command first closes of the first parameter within the query with a single quotation ', and then appended the UNION command with "current_user()", pullling the current user's username of the database represented by string and it finally proceeds to use the "--" at the end to cancel the rest of the comments. </p>

        <li><p>Assuming that the attacker knows that the table 'products' exist somewhere within the database, the attacker can perform:</p></li>

        <li><p><span class="code_space" style="margin-right: 10px;">' UNION SELECT name FROM products -- </span> <button class="buttons" onclick="copyTextOne()">Copy</button></p></li>

        <p>When replaced with the <b style="font-family: 'Courier New', Courier, monospace">$username</b> variable it looks like this:</p>

        <div class="code_space"><span style="color: purple;">SELECT</span> username <span style="color: purple;">FROM</span> users <span style="color: purple;">WHERE</span> username <span style="color: deeppink;">=</span> <span style="color: brown;">''</span> <span style="color: purple;">UNION</span> <span style="color: purple;">SELECT</span> name <span style="color: purple;">FROM</span> products <span style="color: brown;">-- ' AND password = '$password';</span></div>


        <p>The command first closes of the first parameter within the query with a single quotation ', it then proceeds to use the UNION command to pull the column name from the products table, the rest of the query is cancelled out by using the "--" comment.</p>

       </ol>
        

       <ol>


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

        editor.setSize(null, '2050px'); 

        function copyTextOne() {
            var copyText = "' UNION SELECT name FROM products --  ";
            navigator.clipboard.writeText(copyText);
        }


        function copyTextFive() {
            var copyText = "' UNION SELECT current_user() -- ";
            navigator.clipboard.writeText(copyText);
        }

        

        function toggle() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'none';
            var y = document.getElementById("readLess");
            y.style.display = 'inline-block';
        }

        function toggleOff() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'inline-block';
            var y = document.getElementById("readLess");
            y.style.display = 'none';
        }

        function toggleTwo() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'none';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'inline-block';

        }

        function toggleTwoOff() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'inline-block';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'none';

        }

    </script>


</div>
</body>
</html>

