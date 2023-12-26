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

            <div class="sub_description" style="background-image: url('images/in_band.png');">

                <h2 style="margin-top: 0px;">In-Band SQLi</h2>

                <p><b>Description: </b>Being the most frequent type of SQL injections, attackers insert malicious data on a website and immediately retrieve the results of it, all within the same communication interface (E.g, Web Browser).</p>


            </div>

        </div>

        <br>

        <p style="margin: 0px;background-color: #111;color: white;padding: 20px 20px 0px 20px; border-radius: 10px 10px 0px 0px;">There are two common types of In-band SQLi, <b>Error-based</b> and <b>Union-based</b> SQli</p>

        <div class="description" style="flex: none;border-radius: 0px;">

            <div class="sub_description" style="background-image: url('images/error.png');">

                <h3 style="margin-top: 0px;">Error-based</h3>

                <p>An attacker purposely enters data that may cause the database server to produce error messages back to the attacker. These error messages may provide information regarding the database's structure. </p>

                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

                <div id="road">

                    <p><b>Example: </b>An attacker performs an error based SQLi on a search function.</p>

                    <ol class="list">
                        <li>This is the query that is used:</li>
                        <br>
                        <span class="code_space">SELECT * FROM products WHERE name = '$name';</span>
                        <br>
                        <br>
                        <li>The attacker now enters the following:</li>
                        <br>
                        <span class="code_space">1'</span>
                        <br>
                        <br>
                        <li>The query will now look like this:</li>
                        <br>
                        <span class="code_space"><span style="color:purple;">SELECT</span> * <span style="color:purple;">FROM</span> products <span style="color:purple;">WHERE</span> name <span style="color:deeppink;">=</span> '<span style="color:green;">1</span>'';</span>
                        <br>
                        <br>
                        <li>The attacker purposely adds a quotation at the end of the input to cause an error, the database reflects an error back on the same web browser where the attack was launched:</li>
                        <br>
                        <div class="code_space">
                            <p style="margin: 0px;">You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''1''' at line 1;</p>
                        </div>
                        <br>
                        <li>Now the attacker knows that the website is running a MySQL database management system and will narrow down the use of attacks to just focusing on MySQL payloads.</li>

                    </ol>

                    <p><b>Consequences: </b>When these errors are not caught, an attacker can use the information to get, <b>database type and version</b> and <b>the structure of the database.</b></p>

                    <p>Based on the information here, attackers may be able to craft specific attacks based on the type and version of the database being exploited or perform a further exploit using the information attained through the error-based attack on the database.</p>

                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

                </div>

            </div>

        </div>


        <div class="description" style="border-radius: 0px 0px 10px 10px; padding-top: 0px;">

            <div class="sub_description" style="background-image: url('images/union.png'); margin-top: 0px;">

                <h3 style="margin-top: 0px;">Union-based</h3>

                <p>An attackers use the SQL operator <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span>. This operator when used in a SQL query combines the results of two or more <span class="code_space" style="padding: 2px 10px 2px 10px;">SELECT</span> statements. If misused, this operator can result in the display of data from other tables within the database. </p>

                <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>

                <div id="roadTwo">

                    <p><b>Example: </b>An attacker performs an union based SQLi on a search function.</p>

                    <ol class="list">
                        <li>This is the query that is used:</li>
                        <br>
                        <span class="code_space">SELECT name, price FROM products WHERE name = '$name';</span>
                        <br>
                        <br>
                        <li>The attacker enters the following input:</li>
                        <br>
                        <span class="code_space">'UNION SELECT username, password FROM users -- </span>
                        <br>
                        <br>
                        <li>The query will now look like this:</li>
                        <br>
                        <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = ''<span style="color:purple;">UNION </span> <span style="color:purple;">SELECT</span> username, password <span style="color:purple;">FROM</span> users <span style="color:#CD7F32;">-- '</span></div>
                        <br>
                        <li>Within the attacke's payload, the attacker first used a quotation at the start so as to close the quotation of the original query, allowing the <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command to work.</li>
                        <br>
                        <div class="code_space">SELECT name, price FROM product WHERE name = <span style="color:red;">''</span> UNION SELECT username, password FROM users -- '</div>
                        <br>
                        <li>For a <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command to work, it needs to fit two conditions:</li>

                        <ol>
                            <br>
                            <li>Both the number of columns in the original <span class="code_space" style="padding: 2px 10px 2px 10px;">SELECT</span> and <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> needs to be the same. In this case the <span class="code_space" style="padding: 2px 10px 2px 10px;">UNION</span> command gets the username and password from the users table in that database.</li>
                            <br>
                            <div class="code_space">SELECT <span style="color:red;">name, price</span> FROM product WHERE name = '' UNION SELECT <span style="color:red;">username, password</span> FROM users -- '</div>
                            <br>
                            <li>It needs to be the same data type.</li>
                        </ol>

                        <br>
                        <li>Finally, the attacker uses the <span class="code_space" style="padding: 2px 10px 2px 10px;">--</span> command to comment out the last quotation, allowing the command to run with no issue. The attacker will now be able to see all the username and password credentials of the user's table.</li>
                        <br>
                        <div class="code_space">SELECT name, price FROM product WHERE name = '' UNION SELECT username, password FROM users <span style="color:red;">-- '</span></div>

                    </ol>
                    <p><b>Consequences: </b>When attackers are allowed to use the UNION operator within an input, an attacker can retrieve almost every information within the database.</p>
                    
                    <button class="buttons" id="readLessTwo" onclick="toggleTwoOff()" style="display: none;">Read Less</button>
                </div>
            </div>
        </div>

        <br>

        <div class="description">

            <a href="sql_inj/sqli_in_band/sqli_in_band_front_end.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate In Band SQLi Sandbox Demo ></button></a>

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
    </script>

</body>

</html>