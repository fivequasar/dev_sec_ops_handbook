<!DOCTYPE html>

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'navigation.php'; ?>

    <div class="main">

        <div class="description" style="border-radius: 10px 10px 0px 0px; padding-bottom: 0 px; padding: 0px 10px 10px 10px;">
            <div class="sub_description">
                <h2 style="margin-top: 0px;">Stored Cross Site Scripting</h2>
                <p><b>Description: </b>Stored Cross-Site Scripting is where an attacker uses malicious scripts or codes
                    and the content is permanently stored on the target server (e.g., in a database), application, or
                    API. When a user retrieves the affected web page, the script is served to them. The attacker would
                    usually insert their scripts or codes on vulnerable features of a website, for example, the login
                    form
                    of a Restaurant Review Website.</p>
            </div>
        </div>

        <div class="description" style="padding:0px 10px 10px 10px;border-radius:0px; padding-bottom: 0px;">
            <div class="sub_description" style="background-image: url('images/stored.png');">


                <p style="margin-top: 0px;"><b>Example: </b>In this scenario, the attacker wants to inject a script to
                    scrutinize a website by using the Comments feature.</p>

                <ol>
                    <li>This is the code for how the comment is being inserted into the database.</li>
                    <br>

                    <div class="code_space" style="width: 65%">
                        $comment = $_POST['comment']; <br>

                        $conn->query("INSERT INTO comments (content) VALUES ('$comment')");<br>

                        $conn->close();

                    </div>
                    <br>

                    <li>This is the script that the attacker would use to do its malicious attacks:</li>
                    <br>

                    <div class="code_space" style="width: 50%">
                        &lt;script&gt;
                        alert('Stored XSS Attack');
                        &lt;/script&gt;
                    </div>
                    <br>

                    <li>Now, all the attacker had to do is add the script inside the comment and it would look something
                        like this on the query:</li>
                    <br>
                    <div class="code_space" style="width: 65%">
                        $conn->query("INSERT INTO comments (content) VALUES ('<span style="color: red;">This is a great
                            website!&lt;script&gt;alert('Stored XSS Attack')&lt;/script;&gt;</span>')");
                    </div>
                    <br>

                    <li>When another user visits the page and views the comments, the injected script executes
                        automatically. This is because the injected script is now also stored in the database
                        permanently, causing an alert with the message 'Stored XSS Attack' to pop up on the victim's
                        browser.</li>

                </ol>
                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>
                <div id="road">
                    <ol start="5">
                        <li>Let's break down on how it works:</li>
                        <br>

                        <ul>
                            <li style="list-style: circle;">The attacker injects a malicious script into the comment
                                box:</li>
                            <br>

                            <div class="code_space" style="width: 50%"><span style="color: red;">&lt;script&gt;</span>alert('Stored XSS
                                Attack');<span style="color: red;">&lt;/script&gt;</span></div>
                            <br>
                            <li style="line-height: 30px;">And this is the comment form that is used on the Website. Since the form doesn't have any prevensive measures such as
                                Input Validation and Sanitization, the injected script is submitted through the website's
                                comment form:</li>
                            <br>

                            <div class="code_space" style="width: 65%">
                                &lt;form method="post" action="post_comment.php"&gt;<br>
                                &lt;label for="comment"&gt;Leave a comment:&lt;/label&gt;<br>
                                &lt;textarea id="comment" name="comment" rows="4"
                                cols="50"&gt;<span style="color: red;">&lt;script&gt;alert('Stored XSS
                                    Attack');&lt;/script&gt;</span>&lt;/textarea&gt;<br>
                                &lt;input type="submit" value="Submit Comment"&gt;<br>
                                &lt;/form&gt;
                            </div>
                            <br>

                            <li>Upon the submission of the comment form, the website initiates a post action, directing
                                the data to the back end file called post_comment.php file for processing and insertion. At this point, the
                                said file checks and verifies the content of the submitted comment before proceeding to
                                store it in the database. If the content is considered valid, or in this case, as long
                                as the "comment" field contains some content, the comment is stored in the database:</li>
                            <br>
                            <div class="code_space" style="width: 65%">
                                $comment = $_POST['comment']; <br>

                                $conn->query("INSERT INTO comments (content) VALUES ('<span style="color: red;">&lt;script&gt;alert('Stored XSS
                                    Attack');&lt;/script&gt;</span>)");<br>

                                $conn->close();

                            </div>
                            <br>
                            <li>Now, every time a user views the comments section, the stored script is retrieved and
                                executed by their browser, triggering an alert with the message 'Stored XSS Attack'.
                            </li>
                            <br>


                            <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read
                                Less</button>
                        </ul>
                    </ol>
                </div>
            </div>
        </div>

        <div class="description" style="border-radius: 0px 0px 10px 10px; padding: 0px 10px 10px 10px;">
            <div class="sub_description">
                <p style="margin-top: 0px;"><b>Consequences: </b>If successful, the attacker may deploy more nefarious
                    scripts such as website defacement,or using scripts that allows the attacker to gain victims session
                    cookies with the intent of gaining access to the victim's account, allowing them to obtain sensitive
                    information or even make modifications to personal information. Especially if the user has higher
                    privilege such as admin, they can further escalate their attacks on the website.</p>
            </div>
        </div>

        <br>


        <div class="description">

            <a href="stored_xss.php" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Stored XSS Sandbox
                    Demo</button></a>

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