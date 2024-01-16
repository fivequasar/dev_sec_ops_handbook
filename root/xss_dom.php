<!DOCTYPE html>

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="description" style="border-radius: 10px 10px 0px 0px; padding-bottom: 0px;">

            <div class="sub_description">

                <h2 style="margin-top: 0px;">DOM-based XSS</h2>

                <p><b>Description: </b>DOM-based Cross-Site Scripting (XSS) is a type of security vulnerability that occurs in web applications when user-supplied data is improperly handled by the Document Object Model (DOM). In a DOM-based XSS attack, the attacker injects malicious code into the web application, and this code is then executed by the victim's browser within the context of their own session. Unlike traditional XSS attacks, where the malicious script is executed on the server or in the response sent from the server, DOM-based XSS involves the manipulation of the Document Object Model on the client side.</p>
            </div>
        </div>

        <div class="description" style="border-radius: 0px; padding-bottom: 0px;">

            <div class="sub_description" style="background-image: url('images/dom.png');">
                <p style="margin-top: 0px;"><b>Example: </b>In this simple example, lets imagine a webpage that takes a user's name from a URL parameter and displays a personalised greeting.</p>

                <ol>

                    <li>The webpage has a line of code that looks like this:</li>



                    <p>
                        <span class="code_space">
                            var name = window.location.href.split('=')[1];
                            document.getElementById('greeting').innerHTML = 'Hello, ' + name + '!';

                        </span>
                    </p>

                    <li>If an attacker puts a "&lt;script&gt;alert('XSS');&lt;/script&gt;" to the URL of the webpage,the JavaScript would become:</li>
                    
                    <p><span class="code_space">
                            document.getElementById('greeting').innerHTML = 'Hello, &lt;script&gt;alert('XSS');&lt;/script&gt;!';

                        </span></p>
                    
                    <li>The browser interprets the injected script as JavaScript and executes it, causing an alert with the message 'XSS.'</li>
                </ol>
                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>
                <div id="road">
                    
                    <p>Let's analyse this further:</p>
                   
                    <ul>
                        <li>Everytime the user is logged into the website, their username which in this example is "johndoe", will be displayed on the URL in order for the "Hello" message to greet them</li>
                       <br>
                        <span class="code_space">https://example.com/profile?username=<span style="color: red;">johndoe</span> </span>
                       <br>
                       <br>
                        <li style="line-height: 30px;">If we take a closer look at this line of code, you can see that it takes in the name variable without any sanitisation of user input</li>
                        <br>
                        <span class="code_space">var name = window.location.href.split('=')[1]; document.getElementById('greeting').innerHTML = 'Hello, ' +<span style="color: red;"> name </span>+ '!'; </span>
                       <br>
                       <br>
                        <li>So the attacker can just input a script into the URL shown below because the programming of the webpage lacks basic security</li>
                       <br>
                        <span class="code_space">https://example.com/profile?username=<span style="color: red;">&lt;script&gt;alert('XSS');&lt;/script&gt;</span> </span>
                       <br>
                       <br>
                        <li>As a result the page will return an alert message which says "XSS" </li>

                    </ul>
                    
                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>
                </div>

            </div>
        </div>


        <div class="description" style="border-radius: 0px 0px 10px 10px;">

            <div class="sub_description">
                <p style="margin-top: 0px; margin-bottom: 0px;"><b>Consequences: </b>This can lead to the theft of critical user data, session hijacking, and unauthorized user actions. Attackers can deface web pages, spread phishing assaults, and exploit browser vulnerabilities, all of which can result in malware installation.</p>
            </div>
        </div>

        <br>

        <div class="description">

            <a href="xss_dom_front_end.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate DOM-based XSS Sandbox Demo ></button></a>

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
    </script>






</body>

</html>