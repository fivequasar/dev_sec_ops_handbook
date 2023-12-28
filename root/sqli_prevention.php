<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$server = 'localhost';
$username = 'root';
$password = '';

$connOne = new mysqli($server, $username, $password);

$sql = "DROP USER IF EXISTS 'sandbox_user'@'localhost';";
$connOne->query($sql);

$sql = "DROP DATABASE IF EXISTS sample_db;";
$connOne->query($sql);

$connOne = new mysqli($server, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS sample_db;";
$connOne->query($sql);

$db = 'sample_db';

$conn = new mysqli($server, $username, $password, $db);

$sql = "USE sample_db;";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia');";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(50))";
$conn->query($sql);

$sql = "INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')";

$sql = "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20));";
$conn->query($sql);

$sql = "INSERT INTO users (username, password) VALUES ('administrator', 'password');";
$conn->query($sql);

$sql = "CREATE USER IF NOT EXISTS 'sandbox_user'@'localhost' IDENTIFIED BY 'password';";
$conn->query($sql);

$sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON sample_db.* TO 'sandbox_user'@'localhost';";
$conn->query($sql);

$sql = "FLUSH PRIVILEGES;";
$conn->query($sql);

$conn->close();

?>

<!DOCTYPE html>

<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <div class="vertical-menu">

        <a href="index.php">Home</a>

        <a href="sqli_home.php" >SQL Injection</a>

        <a href="sqli_in_band.php" >In-Band SQLI</a>

        <a href="sqli_blind.php" >Blind SQLI</a>

        <a href="sqli_oob.php">OOB SQLI</a>

        <a href="sqli_prevention.php">SQLI Prevention</a>

        <a href="xss_home.php">XSS</a>

</div>

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/prevention.png');background-size: 150px 200px;" > 

        <h2 style="margin-top: 0px;">Prevention Measures</h2>
    
        <p><b>Description: </b>SQLi can be incredibily dangerous when vulnerable on a website, fortunately there are ways to mitigate this. <br></p>  

    </div>

</div>

<br>

<p style="margin: 0px;background-color: #111;color: white;padding: 20px 20px 0px 20px; border-radius: 10px 10px 0px 0px;">There are three main ways to counter SQL Injections, <b>Input Validation</b>, <b>Prepared Statements</b> and <b>Stored Procedures</b></p>

    <div class="description" style="flex: none;border-radius: 0px;">

        <div class="sub_description" style="background-image: url('images/validate.png'); ">

        <h3 style="margin-top: 0px;">Input Validation</h3>

        <p>Have a habit of never trusting any user input, this is why validating the input is super important. Using preg_match can help with validation. preg_match() will help you match patterns based on what you specify. It returns a true or false depending on whether the pattern is found. It is a useful tool for validating user input.</p>

        <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

        <div id="road">

        <p style="margin-top: 0px;"><b>Example: </b>The code below will retrieve the id, name and country based on the id provided by the user. Notice that for the variable $id, it is not properly validated, attackers can enter strings instead of intergers to cause an error, what we want is to only allow intergers to be accepted and nothing else. </p>

        <div class="code_space">
            $id = $_GET["id"];<br>
            $stmt = $conn->prepare("SELECT id, name, country FROM products WHERE id = ?");<br>
            $stmt->bind_param("i", $id);<br>
            $stmt->execute();<br>
        </div>

        <p>
             Using preg_match we could only allow integers to be accepted, else return with an error.
        </p>

        <div class="code_space">
            $id = $_GET["id"];<br>
            if (!preg_match('/^\d+$/', $id)) {<br>
                die("Error: ID must be an integer.");<br>
            } else {<br>
                /****/ Prepared Statement Goes Here.<br>
            }
        </div>
        <p>Within the preg_match function, let's analyse what each symbol does. </p>
        <ol>
            <li><span class="code_space">/…/</span> This is a container, to show where to expression starts and ends</li>
                <br>
            <li><span class="code_space">^</span> Ensures that the matching starts at the first character of the input</li>
                <br>
            <li><span class="code_space">\d</span> Ensures that the input only allows digits from 0 to 9</li>
                <br>
            <li><span class="code_space">+</span> Allows more than 1 digit.</li>
                <br>
            <li><span class="code_space">$</span> Ensures the matching pattern continues all the way to the end of the input.</li>
        </ol>

        <p>This helps better defend against a SQL injection. For more information regarding creating patterns for input validation, go to https://regexr.com/.</p>

        <br>
        <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>
        </div>
    </div>
</div>

<div class="description" style="border-radius: 0px; padding-top: 0px;"> 

<div class="sub_description" style="background-image: url('images/prepared.png');margin-top: 0px; background-size: 285.11px 142.56px;">

    <h3 style="margin-top: 0px;">Prepared Statement</h3>

        <p>Using prepared statements splits the SQL query and the user input data apart from each other, it is then sent to the database seperately.  </p>

        <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>

        <div id="roadTwo">

        <p>Using prepared statements splits the SQL commands and the input data apart from each other, which in a way prevents SQL injections. </p>

        <p>Prepared Statements uses parameters within the query, here is an example:</p>

        <p>Instead of: </p>

        <div class="code_space">SELECT username FROM users WHERE username = '$username' AND password = '$password';</div>

        <p>With prepared statements it is now:</p>

        <div class="code_space">$stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ? AND password = ?");</div>

        <p>Notice that instead of the variables being the query, it is being swapped out with a ? instead. These ? are called parameters. The database first run this query with the ? in it. The database will recognise that the query contains parameters and will only execute when the user-supplied data is given.</p>

        <p>The user supplied data will be inserted in the parameters like this:</p>

        <div class="code_space">$stmt->bind_param("ss", $username, $password);</div>

        <p>Within the bind_param function, depending on the number of parameters have, you need to first specify what type of data the variable holds, all possible arguments for this are:</p>

        <ul>
            <li>s for strings</li>
            <li>i for interger</li>
            <li>d for double </li>
            <li>b for blob</li>
        </ul>

        <p>The variable containing the input will then be placed after data type specification, separated by the delimiter “,”. The variables will need to be arranged in the same order based on the parameters in the prepared statement.</p>

        <p>In a scenario where an attacker performs a union-based SQL Injection on this query, they can't because the UNION based command will be taken as an actual single value. So, if the attacker were to perform the UNION statement again, it will look like this.</p>

        <div class="code_space">SELECT username FROM users WHERE username = '<span style="color:red;">1' UNION SELECT name FROM products -- </span>' AND password = '$password';</div>

        <p>The SQL command will actually search for the id which is: <div class="code_space" style="color:red;">1' UNION SELECT name FROM products -- </div></p>

        <button class="buttons" id="readLessTwo" onclick="toggleTwoOff()" style="display: none;">Read Less</button>

        </div>
    </div>
</div>

<div class="description" style="border-radius: 0px 0px 10px 10px; padding-top: 0px;"> 

<div class="sub_description" style="background-image: url('images/stored.png');margin-top: 0px;">

    <h3 style="margin-top: 0px;">Stored Procedures</h3>

        <p>Stored procedures are similar to creating functions in programming. You first create a stored procedure in the SQL database for use in the code. Then within the code, you call the procedure.</p>

        <button class="buttons" id="readMoreThree" onclick="toggleThree()">Read More</button>

        <div id="roadThree">

        <p>Stored Procedures is very similar like calling a function in a code, you create the function with parameters, then you call it in when needed and it is created within the database itself.</p>

        <p>The query below creates a procedure named GetProductsData, with a single parameter that is an interger:</p>

        <div class="code_space">
        DELIMITER //<br>
        CREATE PROCEDURE GetProductsData(IN input_id INT)<br>
        BEGIN<br>
            SELECT id, name, country FROM products WHERE id = input_id;<br>
        END //<br>
        DELIMITER;<br>
        </div>

        <p>And in the actual code itself, you can call the function created on the SQL side to initiate the query.</p>

        <div class="code_space">

        $stmt = $conn->prepare("CALL GetProductsData(?)");<br>
        $stmt->bind_param("i", $id);<br>
        $stmt->execute();<br>

        </div>

        <br>


        <button class="buttons" id="readLessThree" onclick="toggleThreeOff()" style="display: none;">Read Less</button>

        </div>
    </div>
</div>

</div> 
<script> 
    function toggle() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'none';
            var y = document.getElementById("readLess");
            y.style.display = 'block';
        }
        function toggleOff() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'block';
            var y = document.getElementById("readLess");
            y.style.display = 'none';
        }
        
        function toggleTwo() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'none';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'block';
        }

        function toggleTwoOff() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'block';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'none';
        }

        function toggleThree() {
            var x = document.getElementById("roadThree");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreThree");
            y.style.display = 'none';
            var y = document.getElementById("readLessThree");
            y.style.display = 'block';
        }

        function toggleThreeOff() {
            var x = document.getElementById("roadThree");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreThree");
            y.style.display = 'block';
            var y = document.getElementById("readLessThree");
            y.style.display = 'none';
        }

</script>
</body>
</html> 
