<!DOCTYPE html>

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="description">

            <div class="sub_description" style="background-image: url('images/info.png');">

                <h2 style="margin-top: 0px;">Cross-site Scripting</h2>

                <p><b>Description:</b> Cross-site scripting (XSS) is a type of security vulnerability commonly found in web applications. It occurs when an attacker injects malicious scripts into a web page, which is then executed by a user's browser. Think of cross site scripting as having a notice board. You would want to see important updates or news of a particular subject, however someone pasted a funny picture instead, and when others wants to read it, they can only see the funny picture.</p>

            </div>
        </div>

        <br>

        <div style="margin-bottom: 0px;padding: 20px 20px 0px 20px;background-color: #111;border-radius: 10px 10px 0px 0px;color: white;"> Cross-site Scripting are split into three main categories, Stored XSS, Reflected XSS and DOM-based XSS.</div>

        <div class="description" style=" border-radius: 0px 0px 10px 10px;">



            <div class="sub_description" style="background-image: url('images/stored.png');">

                <h3 style="margin-top: 0px">Stored XSS</h3>

                <p>Stored XSS is a type of web security vulnerability where malicious scripts are injected into a website's database and later served to users, potentially leading to the execution of unauthorized actions in their browsers.</p>

                <a href="xss_stored.php"><button class="buttons">Read More ></button></a>

            </div>

            <div class="sub_description" style="background-image: url('images/bug.png'); background-size: 300px 262.11px;">



                <h3 style="margin-top: 0px">Reflected XSS</h3>

                <p>Reflected XSS is a web security vulnerability in which an attacker injects malicious scripts into a web application, and the user inadvertently executes them when interacting with a crafted URL or input, allowing the attacker to steal sensitive information.</p>

                <a href="xss_reflected.php"><button class="buttons">Read More ></button></a>

            </div>

            <div class="sub_description" style="background-image: url('images/dom.png');">

                <h3 style="margin-top: 0px">DOM-based XSS</h3>

                <p>DOM-based XSS is a web security vulnerability where client-side scripts manipulate the Document Object Model (DOM) of a web page, leading to the execution of malicious code in the user's browser without involving server-side vulnerabilities.</p>

                <a href="xss_dom.php"><button class="buttons">Read More ></button></a>

            </div>

        </div>

        <br>

        <div class="description">

            <div class="sub_description" style="background-image: url('images/prevention.png'); background-size: 150px 200px;  padding: 30px;">

                <h3 style="margin-top: 0px">XSS Prevention Measures</h3>

                <p>We have design a two-layer architecture which aims to guide developrs into creating a secure environment safe from XSS attacks.</p>

                <a href="xss_prevention.php"><button class="buttons">Find out how you can protect yourself from XSS Vulnerabilities ></button></a>

            </div>

        </div>

    </div>

    </div>
</body>

</html>