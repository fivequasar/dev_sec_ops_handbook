@if (Route::has('login'))
    @auth
    <script >window.location = "{{ url('/index') }}";</script>
    @else


@include('layouts.navigation_out')

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/blind.png');" > 

        <h2 style="margin-top: 0px;">Blind SQLi</h2>
    
        <p><b>Description: </b>An attacker sends a payload over and based on the results and reaction given by the server, then proceeds to build a profile on the architecture of the database. This process may take longer compared to in-band SQLi as the results of the payload may not be directly reflected and it heavily relies on how the web application reacts to it. <br></p>  
        

    </div>

</div>

<br>

<p style="margin: 0px;background-color: #111;color: white;padding: 20px 20px 0px 20px; border-radius: 10px 10px 0px 0px;">There are two types of blind attacks <b>Boolean-based</b> and <b>Time-based</b> SQLi</p>

    <div class="description" style="flex: none;border-radius: 0px;padding-bottom: 0px 20px 0px 20px;">

    

        <div class="sub_description" style="background-image: url('images/boolean.png');">

        <h3 style="margin-top: 0px;">Boolean-based</h3>

        <p>Boolean-based SQL injections is when an attacker crafts a SQL query in an attempt to force the application to send back either any response with two outcomes (True or False).</p>

        <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

        <div id="road">

        <p><b>Example: </b>An attacker performs an boolean based SQLi on a search function.</p>

            <ol class="list">
                
                <li>The SQL query in the back end looks like this:</li>
                    <br>
                <span class="code_space">SELECT name, price FROM product WHERE name = '$name';</span>
                    <br>
                    <br>
                <li>Based on this query, an attacker will first need to enter a valid input, in this case is:</li>
                    <br>
                <span class="code_space">Apples</span>
                    <br>
                    <br>
                <li>The query will now look like this:</li>
                    <br>
                <span class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name <span style="color:deeppink;">=</span> <span style="color:brown;">'Apples'</span>;</span>
                    <br>
                    <br>
                <li>It will return:</li>
                    <br>
                <span class="code_space">Result: Apples, $0.50</span>
                    <br>
                    <br>
                <li>The SQL returns with a result of the name and price of Apples, the attacker can now try:</li>

                <p><span class="code_space">Apples' AND 1 = 1 -- </span></p>

                <p><span class="code_space">Apples' AND 1 = 2 -- </span></p>

                <li>When both commands are placed in the query, it will look like this:</li>
                <p>When the SQL receives the value 'AND 1 = 1', it will return true as 1 equates to 1, it will then return the specified entry within the WHERE clause.</p>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:darkred;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:green;">1 <span style="color:deeppink;">=</span> 1</span> <span style="color:#CD7F32;">-- '</span></div>
                <p>And thus, it will return:</p>
                <span class="code_space">Result: Apples, $0.50</span>
                <br>
                <p>When the SQL receives the value 'AND 1 = 2', it will return false as 1 does not equate to 2, which will return no entries within the WHERE clause.</p>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:darkred;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:green;">1 <span style="color:deeppink;">=</span> 2</span> <span style="color:#CD7F32;">-- '</span></div>
                <p>And thus, it will return:</p>
                <span class="code_space">Result: 0 results.</span>
                <br>
                <br>
                <li>By performing the first line and receiving the name and price of Apples, but not returning anything from the second command, makes it vulnerable to SQL injection. Attackers can use this as an navigator to reveal data and map out the structure of the database.</li>
                <br>
                <li>The attacker can then proceed to perform:</li>
                    <br>
                <div class="code_space">Apples' AND EXISTS( SELECT * FROM users WHERE username ='admin')-- '</div>
                    <br>
                <li>The query now looks like:</li>
                    <br>
                <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:brown;">'Apples'</span> <span style="color:purple;">AND</span> <span style="color:purple;">EXISTS</span>(<span style="color:purple;">SELECT</span> * <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username = <span style="color:brown;">'admin'</span>)<span style="color:#CD7F32;">-- '</span></div>
                    <br>                
                <li>An attacker may now attempt brute force attacks to determine if there is a username named 'admin' within the user's table. If the entry returns then it would be true, or else, it would be false.</li>

            </ol>
                <p><b>Consequences: </b>When these boolean-attacks are allowed within an input, an attacker can use this vulnerability to recreate the database and potentially reveal sensitive data through either true, or false results given by the application.</p>
                <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>
        </div>
    </div>
</div>
<div class="description" style="border-radius: 0px 0px 10px 10px; padding-top: 0px;"> 

<div class="sub_description" style="background-image: url('images/time.png'); margin-top: 0px;">

    <h3 style="margin-top: 0px;">Time-based</h3>

        <p>In a scenario when the attacker is unable to see the results of their payload being either true or false, another way is to set a time-based injection. This method involves modifying the SQL query to cause the database to delay its response for a certain amount of time if a specific condition is met. The response time can tell attackers if their SQL query is true or false. </p>

        <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>

        <div id="roadTwo">

        <p><b>Example: </b>An attacker faces an issue where the Boolean attack does not work, it instead says “Ok!” no matter if the input is valid or not. </p>

        <ol>

            <li>The SQL query in the back end looks like this:</li>

            <br>
        
            <span class="code_space">SELECT name, price FROM product WHERE name = '$name';</span>

            <br>
            <br>

            <li>When the attacker places a normal input:</li>

            <br>

            <span class="code_space">Apples</span>

            <br>
            <br>

            <li>It will just reply with:</li>

            <br>

            <span class="code_space">Result: 'OK!'</span>

            <br>
            <br>

            <li>If the attacker tries to force the application to produce a "true" outcome using the boolean-based attack:</li>

            <br>

            <span class="code_space">Apples' AND 1 = 1</span>

            <br>
            <br>

            <li>It will, yet again, reply with:</li>

            <br>

            <span class="code_space">Result: 'OK!'</span>

            <br>
            <br>

            <li>If the attacker tries to force the application to produce a "false" outcome using the boolean-based attack:</li>

            <br>

            <span class="code_space">Apples' AND 1 = 2</span>

            <br>
            <br>

            <li>It will still reply with:</li>

            <br>

            <span class="code_space">Result: 'OK!'</span>

            <br>
            <br>
            

            <li>The attacker then proceeds to try and perform a time-based attack.</li>

            <br>

            <span class="code_space">' AND IF(1=1,SLEEP(5),SLEEP(0)) -- </span>

            <br>
            <br>

            <li>The query will now look like this:</li>

            <br>

            <span class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:brown;">''</span> <span style="color:purple;">AND</span> <span style="color:purple;">IF</span>(<span style="color:green;">1</span><span style="color:deeppink;">=</span><span style="color:green;">1</span>,SLEEP(<span style="color:green;">5</span>),SLEEP(<span style="color:green;">0</span>)) <span style="color:#CD7F32;">-- '</span></span>

            <br>

            <p>The attacker uses an if statement, within the if statement, if 1 does equate to 1, delay the execution for 5 seconds or else execute it immediately. </p>

            <li>The attacker then tries 1 = 2:</li>

            <br>

            <span class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:brown;">''</span> <span style="color:purple;">AND</span> <span style="color:purple;">IF</span>(<span style="color:green;">1</span><span style="color:deeppink;">=</span><span style="color:green;">2</span>,SLEEP(<span style="color:green;">5</span>),SLEEP(<span style="color:green;">0</span>)) <span style="color:#CD7F32;">-- '</span></span>


            <br>

            <p>Since 1 does not equate to 2, SQL will immediately run the command immediately.</p>

            <li>The attacker now knows that this component is vulnerable to SQLi and can thus perform a brute force attack to check if, within the users table, is there a username with the value of 'admin' based on the time:</li>

            <br>
            
            <div class="code_space"><span style="color:purple;">SELECT</span> name, price <span style="color:purple;">FROM</span> product <span style="color:purple;">WHERE</span> name = <span style="color:brown;">''</span> <span style="color:purple;">AND</span> <span style="color:purple;">IF</span>(<span style="color:purple;">EXISTS</span>(<span style="color:purple;">SELECT</span> * <span style="color:purple;">FROM</span> users <span style="color:purple;">WHERE</span> username = <span style="color:brown;">'admin'</span>, <span style="color:black;">SLEEP</span>(<span style="color:green;">5</span>), <span style="color:black;">SLEEP</span>(<span style="color:green;">0</span>))<span style="color:#CD7F32;">-- '</span></div>
            
        </ol>

        <p><b>Consequences: </b>Even if boolean-based attacks dosen't work, attacker will still be able to reconstruct the database and still potentially reveal sensitive data but in a much slower pace.</p>
            
        <button class="buttons" id="readLessTwo" onclick="toggleTwoOff()" style="display: none;">Read Less</button>

        </div>
    </div>
</div>


<br>

    <div class="description">

        <a href="{{route('blind_front_end')}}" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Login To Initiate Blind SQLi Sandbox Demo ></button></a>

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

@endauth

@endif