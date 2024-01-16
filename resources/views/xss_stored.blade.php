@include('db_reset')

@include('layouts.navigation')

<div class="main">

        <div class="description" style="border-radius: 10px 10px 0px 0px; padding: 10px 10px 0px 10px;">

            <div class="sub_description" style="background-image: url('images/stored.png'); ">

                <h2 style="margin-top: 0px;">Stored XSS</h2>

                <p><b>Description: </b>Stored Cross-Site Scripting is where an attacker uses malicious scripts or codes and the content is permanently stored on the target server (e.g., in a database), application, or API. When a user retrieves the affected web page, the script is served to them. The attacker would usually insert their scripts or codes on vulnerable features of a website, for example, the comment box of a Restaurant Review Website.

</p>
            </div>

            

        </div>

        <div class="description" style="border-radius: 0px; padding: 0px 10px 0px 10px;">

            <div class="sub_description" style="background-image: url('images/example.png'); margin: 10px 15px 10px 15px; background-size: 192.53px 224.66px;">

                <p style="margin-top: 0px;"><b>Example: </b> A comment section that enables users to post message and view all messages at the same time. In our scenario, an attacker adds a script within a website through a posting a comment. </p>

                

                <ol id="list">

                    <li>This is the current message forum, users will be able to see other people's messages from here:</li>


                    <p class="code_space">Message 1: How is everyone today? <br>Message 2: What a beautiful morning!</p>
       
                    
                    <li>The forum also allows the insertion of comments too, the following query is used for adding comments:</li>

                    <br>
                    <span class="code_space">INSERT INTO comments (message) VALUES (?)</span>
                    <br>
                    <br>

                    </ol>


                    <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

                    <div id="road">

                    <ol start="3" style="margin-top: 0px;">

                    

                    <li>When user inputs are not properly validated. A potential attacker can insert the following within the comments section:</li>

                    <br>
                    <span class="code_space">&lt;script&gt;alert('XSS')&lt;/script&gt;</span>
                    <br>

                    <li><p>The payload would then proceed to be <b>stored</b>. If viewed from the database management system, it will look like:</p></li>

                    <div class="db_table">
                    <table>

                    <tr><th>id</th><th>message</th></tr>
                    <tr><td>1</td><td>How is everyone today?</td></tr>
                    <tr><td>2</td><td>What a beautiful morning!</td></tr>
                    <tr><td>3</td><td>&lt;script&gt;alert('XSS')&lt;/script&gt;</td></tr>

                    </table>

                    </div>

                    <li><p>The entire payload will be sent over to the database and when viewing the message forum again it will look like:</li>

                    <p class="code_space">Message 1: How is everyone today? <br>Message 2: What a beautiful morning!<br>Message 3:</p>

                    <li>The browser will not display the script tag as the browser will see it as an actual script elements and run the contents within. In this case, this will produce a pop-up message on the user's browser with the words "XSS" when a user views the message forum. </li>

                </ol>

                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

                </div>

                

                
            </div>

            
        </div>

                <div class="description" style="border-radius: 0px 0px 10px 10px; padding: 0px 10px 10px 10px;">
                <div class="sub_description" style="background-image: url('images/con.png'); margin: 10px 15px 10px 15px; background-size: 214.17px 197.67px; ">
                    <p style="margin-top: 0px; margin-bottom: 0px;"><b>Consequences:</b> When inputs are not properly sanitized or validated, and scripts tags are allowed to be inserted within a database, it allows attackers to potentially perform more greater attacks like stealing user's cookie's to gain access to their accounts. In this case, to whomever views the comments</p>
                </div>

        </div>

        <br>

        <div class="description">

        <a href="{{route('stored_front_end')}}" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Stored XSS Demo ></button></a>

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
            document.getElementById("list").style.marginBottom = "0px";

        }
function toggleOff() {
            var x = document.getElementById("road");
            x.classList.toggle('active');
            var y = document.getElementById("readMore");
            y.style.display = 'block';
            var y = document.getElementById("readLess");
            y.style.display = 'none';
            document.getElementById("list").style.marginBottom = "22px";
        }

</script>





