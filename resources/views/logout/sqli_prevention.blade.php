@if (Route::has('login'))
    @auth
    <script >window.location = "{{ url('/index') }}";</script>
    @else


@include('layouts.navigation_out')

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/prevention.png');background-size: 150px 200px;" > 

        <h2 style="margin-top: 0px;">Prevention Measures</h2>
    
        <p><b>Description: </b>SQLi can be incredibily dangerous when vulnerable on a website, fortunately there are ways to mitigate this. <br></p>  

    </div>

</div>

<br>

<p style="margin: 0px;background-color: #111;color: white;padding: 20px 20px 0px 20px; border-radius: 10px 10px 0px 0px;">There are two ways to counter SQL Injections, <b>Input Validation</b>, and <b>Prepared Statement</b></p>

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

        <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

        </div>
    </div>
</div>

<div class="description" style="border-radius: 0px; padding-top: 0px;border-radius: 0px 0px 10px 10px;"> 

<div class="sub_description" style="background-image: url('images/code.png');margin-top: 0px; background-size: 285.11px 142.56px;">

    <h3 style="margin-top: 0px;">Prepared Statement</h3>

        <p>Using prepared statements splits the SQL query and the user input data apart from each other, it is then sent to the database seperately. Which in a way prevents SQL injections.  </p>

        <button class="buttons" id="readMoreTwo" onclick="toggleTwo()">Read More</button>

        <div id="roadTwo">

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

<br>

<div class="description">

<a href="{{route('sql_secure_front_end')}}" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Login To Initiate Secure SQL Sandbox Demo ></button></a>

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

@endauth

@endif