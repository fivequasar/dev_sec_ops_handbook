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

                <h2 style="margin-top: 0px;">Reflected XSS</h2>

                <p><b>Description: </b>
                    Reflected Cross-Site Scripting (XSS) exploits web applications not properly validating or sanitizing an user input. This type of attack can be activated through various responses, such as error messages, search results, or any other server response that includes user input as part of the request, like comments or search parameters. In instances where the website fails to adequately check and ensure the safety of incoming requests, the injected malicious scripts are reflected off the web server and executed in the context of the victim's browser, posing risks such as data theft, session hijacking, and unauthorized code execution.</p>
            </div>
        </div>

        <div class="description" style="padding:0px 10px 10px 10px;border-radius:0px; padding-bottom: 0px;">

            <div class="sub_description" style="background-image: url('images/bug.png');">

                <p style="margin-top: 0px;"><b>Example: </b> imagine you are on a website that has a search engine. You search a keyword and the payload reflects back your search parameter.
                </p>

                <ol>


                    <li>This is an example of a code form for a search engine.</li>
                    <br>
                    <div class="code_space">&lt;form method="GET" action="search_page.php"&gt; <br>
                        &lt;input type="text" name="search" placeholder="Enter your search..." /&gt; <br>
                        &lt;input type="submit"value="Search" /&gt;<br>
                        &lt;/form&gt;
                    </div>
                    <br>
                    <li>When a user submits a keyword "technology", the payloads look like this:</li>
                    <br>
                    <div class="code_space">https://example.com/search_page.php?search=<span style="color: red;">technology</span></div>
                    <br>
                    <li>If an attacker injects a "&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;</span>" into the payload, it will look like this:</li>
                    <br>
                    <div class="code_space">https://example.com/search_page.php?search=technology<span style="color: red;">&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;</span></div>
                    <br>
                    <li>The web application reflects the search query back into the HTTP response. In this case, the search query is displayed within an HTML context. When the browser processes the HTTP response, it executes the script within the script tags, causing the alert to be displayed as a pop up message box.</li>
                    <br>
                    <span class="code_space">Reflected XSS attack! </span>

                </ol>
                <br>
                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

                <div id="road">
                    <p>Let's examine this more closely.</p>
                    <ol>
                        <ul>
                            <li>Using the method="GET", the form data will be appended to the URL when the form is submitted. In this example, the form sends data to the "search_page.php" script using the GET method. This exposes sensitive information directly in the URL, making it visible to anyone who has access to the browser history, bookmarks, or network traffic.</li>
                            <br>
                            <div class="code_space">&lt;form <span style="color: red;">method="GET"</span> action="search_page.php"&gt; <br>
                                &lt;input type="text" name="search" placeholder="Enter your search..." /&gt; <br>
                                &lt;input type="submit"value="Search" /&gt;<br>
                                &lt;/form&gt;
                            </div>
                            <br>
                            <li>Whenever a user search a keyword, for example, "cups & plates" it gets reflected back to the user's payload like so:</li>
                            <br>
                            <div class="code_space">https://example.com/search_page.php?search=<span style="color: red;">cups+&+plates</span></div>
                            <br>
                            <li>With so, we can see that the special characters are not escaped properly and thus an attacker can insert a malicious script into the payload like so:</li>
                            <br>
                            <div class="code_space">https://example.com/search_page.php?search=cups+&+plates<span style="color: red;">&lt;script&gt;alert("Reflected XSS attack!");&lt;/script&gt;</span></div>
                            <br>
                            <li>As a result, the payload loads the script and the message box will pop up.</li>
                            <br>
                            <span class="code_space">Reflected XSS attack! </span>


                        </ul>
                    </ol>
                    <br>
                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

                </div>



            </div>

        </div>


        <div class="description" style="padding:0px 10px 10px 10px;border-radius: 0px 0px 10px 10px; padding-bottom: 10px;">

            <div class="sub_description">

                <p style="margin-top: 0px;"><b>Consequences: </b>Through the injection and execution of malicious scripts in a web application, XSS gives attackers the ability to compromise user information and website integrity and can result in data theft, session hijacking, phishing, and issues with user trust.</p>

            </div>

        </div>
        <br>
        <div class="description">

            <a href="reflected_xss.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Reflected XSS Sandbox Demo ></button></a>

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