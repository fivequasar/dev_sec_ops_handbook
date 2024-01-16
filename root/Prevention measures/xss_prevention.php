<?php

include 'db_creation.php';

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

    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="description">

            <div class="sub_description" style="background-image: url('images/prevention.png');background-size: 150px 200px;">

                <h2 style="margin-top: 0px;">XSS Prevention Measures</h2>

                <p><b>Description: </b>XSS can be incredibily dangerous when vulnerable on a website, fortunately there are ways to mitigate this. <br></p>

            </div>

        </div>

        <br>

        <p style="margin: 0px;background-color: #111;color: white;padding: 20px 20px 0px 20px; border-radius: 10px 10px 0px 0px;">There are two ways to counter XSS Attacks, <b>Input Validation</b>, and <b>HTML Encoding</b></p>

        <div class="description" style="flex: none;border-radius: 0px;">

            <div class="sub_description" style="background-image: url('.png'); ">

                <h3 style="margin-top: 0px;">Input Validation</h3>

                <p>Input validation is to check and sanitize user inputs to make sure that no malicious scripts or code that could be used by a web application. When malicious scripts are injected into web pages that are subsequently seen by other users, an attacker may be able to compromise other users' accounts or steal confidential data.</p>

                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

                <a href="xss_input_validation.php"><button class="buttons" id="sandboxOne" style="display: inline-block;">Initiate Input Validation Sandbox ></button></a>

                <div id="road">

                    <p style="margin-top: 0px;"><b>Example: </b>The code below will allow any input to be entered, as long as the input for the username is not empty. This gives a chance for the attacker to put in a malicious script or code.</p>

                    <div class="code_space">
                        function validateUsername($username) {<br>
                        if (!empty($username)) {<br>
                        echo 'Valid input';<br>
                        } else {<br>
                        echo 'Invalid input';<br>
                        }<br>
                        }
                    </div>

                    <p>
                        Using a whitelist (line in red), we state what type of characters we allow the user to input.
                    </p>

                    <div class="code_space">
                        function validateUsername($username)<br>
                        {<br>
                        <span style="color:red">$allowedCharacters = '/^[a-zA-Z0-9]+$/';</span><br>
                        if (preg_match($allowedCharacters, $username)) {<br>
                        echo 'Valid input';<br>
                        } else {<br>
                        echo 'Invalid input';<br>
                        }<br>
                        }
                    </div>
                    <p>Within the whitelist, let's analyse what each symbol does. </p>
                    <ol>
                        <li><span class="code_space">/…/</span> Show where the expression starts and ends.</li>
                        <br>
                        <li><span class="code_space">^</span> Ensures that the matching starts at the first character of the input.</li>
                        <br>
                        <li><span class="code_space">[a-zA-Z0-9]</span> Denotes a character class that includes uppercase letters (A-Z), lowercase letters (a-z), and digits (0-9).</li>
                        <br>
                        <li><span class="code_space">+</span> Allows more than 1 digit.</li>
                        <br>
                        <li><span class="code_space">$</span> Ensures the matching pattern continues all the way to the end of the input.</li>
                    </ol>

                    <p>In summary, the <span class="code_space"> `/^[a-zA-Z0-9]+$/`</span> enforces the following rules:</p>
                    <ol>
                        <li>The string must start with at least one alphanumeric character (uppercase letter, lowercase letter, or digit).</li>
                        <br>
                        <li>The string can contain any combination of uppercase letters, lowercase letters, and digits.</li>
                        <br>
                        <li>The string must end with an alphanumeric character.</li>
                    </ol>
                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

                    <a href="xss_input_validation.php"><button class="buttons">Initiate Input Validation Sandbox ></button></a>

                </div>
            </div>
        </div>

        <div class="description" style="border-radius: 0px; padding-top: 0px;border-radius: 0px 0px 10px 10px;">

            <div class="sub_description" style="background-image: url('images/prepared.png');margin-top: 0px; background-size: 285.11px 142.56px;">

                <h3 style="margin-top: 0px;">HTML Encoding</h3>

                <p>Encoding is the process of converting data into a specific format for secure transmission, storage, or representation. With the htmlspecialchars() function, you will be able to encode characters to their respective HTML entities so that scripts will not be able to execute</p>

                <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>


                <a href="encoding.php"><button class="buttons" id="sandboxTwo" style="display: inline-block;">Initiate HTML Encoding Sandbox ></button></a>

                <div id="roadTwo">

                    <p>The htmlspecialchars() function is typically used to prevent XSS attacks. Here is a simple example:</p>

                    <p>Instead of: </p>

                    <div class="code_space">$username = "johndoe";</div>

                    <p>With encoding it is now:</p>

                    <div class="code_space">
                        $username = "johndoe";
                        <br>
                        $encodedUsername = htmlspecialchars($username, ENT_QUOTES);
                    </div>

                    <p></p>

                    <p>Here are characters that htmlspecialchars() can encode into their HTML entities counterparts:</p>

                    <ul>
                        <li>&amp; will be converted to &amp;amp;</li>
                        <li>" will be converted to &amp;quot;</li>
                        <li>' will be converted to &amp;#039;</li>
                        <li>&lt; will be converted to &amp;lt;</li>
                        <li>&gt; will be converted to &amp;gt;</li>
                    </ul>

                    <p>So if an attacker were to somehow input a script into the username:</p>

                    <div class="code_space">
                        $username = "&lt;script&gt;alert('XSS');&lt;/script&gt;";
                        <br>
                        $encodedUsername = htmlspecialchars($username, ENT_QUOTES);
                    </div>

                    <p>The HTML output would be:</p>

                    <div class="code_space">&amp;lt;script&amp;gt;alert(&amp;quotXSS&amp;quot);&amp;lt;/script&amp;gt;</div>

                    <p>Whereas the browser output would still be:</p>

                    <div class="code_space">&lt;script&gt;alert('XSS');&lt;/script&gt;</div>


                    <p>So why does the browser still displays the "<" and the single quotation marks as they are and not their encoded counterparts? Lets break it down:</p>

                            <ol>
                                <li>Server side</li>
                                <br>
                                <ul>
                                    <li>Data is received and processed on the server.</li>
                                    <br>
                                    <li>htmlspecialchars() will convert special characters into HTML entities.</li>
                                    <br>
                                    <li>The server sends the encoded HTML to the client's browser</li>
                                </ul>
                                <br>
                                <li>Client side</li>
                                <br>
                                <ul>
                                    <li>The browser receives the encoded HTML content</li>
                                    <br>
                                    <li>The browser renders the HTML, displaying the encoded characters as text on the web page</li>
                                    <br>
                                    <li>The encoded characters are visible to the user, ensuring that any potential scripting or malicious code is treated as plain text rather than executable code</li>
                                </ul>
                            </ol>

                            <button class="buttons" id="readLessTwo" onclick="toggleTwoOff()" style="display: none;">Read Less</button>

                            <a href="encoding.php"><button class="buttons">Initiate HTML Encoding Sandbox ></button></a>

                </div>
            </div>

        </div>

        <br>

        <div class="description">

            <a href="sql_secure_front_end.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Secure SQL Sandbox Demo ></button></a>

        </div>

    </div>
    <script>
        function toggle() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'none';
            var y = document.getElementById("readLess");
            y.style.display = 'inline-block';
            var z = document.getElementById("sandboxOne");
            z.style.display = 'none';
        }

        function toggleOff() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'inline-block';
            var y = document.getElementById("readLess");
            y.style.display = 'none';
            var z = document.getElementById("sandboxOne");
            z.style.display = 'inline-block';

        }

        function toggleTwo() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'none';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'inline-block';
            var z = document.getElementById("sandboxTwo");
            z.style.display = 'none';
        }

        function toggleTwoOff() {
            var x = document.getElementById("roadTwo");
            x.classList.toggle('active');
            var y = document.getElementById("readMoreTwo");
            y.style.display = 'inline-block';
            var y = document.getElementById("readLessTwo");
            y.style.display = 'none';
            var z = document.getElementById("sandboxTwo");
            z.style.display = 'inline-block';
        }
    </script>
</body>

</html>