@if (Route::has('login'))
    @auth
    <script >window.location = "{{ url('/index') }}";</script>
    @else


@include('layouts.navigation_out')

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/xss.png');">

        <h2 style="margin-top: 0px;">Cross-site Scripting</h2>

        <p><b>Description:</b> Cross-site scripting, otherwise known as XSS, is a type of security vulnerability commonly found in web applications. It occurs when an attacker injects malicious scripts into a web page, which is then executed by a user's browser.</p> 
               

    </div>
</div>

<br>

<div style="margin-bottom: 0px;padding: 20px 20px 0px 20px;background-color: #111;border-radius: 10px 10px 0px 0px;color: white;"> Cross-site Scripting are split into three main categories, Stored XSS, Reflected XSS and DOM-based XSS.</div>

<div class="description" style=" border-radius: 0px 0px 10px 10px;">



    <div class="sub_description" style="background-image: url('images/stored.png'); background-size: 250px 250px;">

        <h3 style="margin-top: 0px">Stored XSS</h3>

        <p>A Stored XSS vulnerability involves injecting malicious scripts that is stored on a website, which would lead to unauthorized actions in victim's browsers when accessed.</p>

        <a href="{{route('xss_stored_out')}}"><button class="buttons">Read More ></button></a>

    </div>

    <div class="sub_description" style="background-image: url('images/reflect.png'); background-size: 250px 250px;">



        <h3 style="margin-top: 0px">Reflected XSS</h3>

        <p>Reflected XSS is a web security vulnerability in which an attacker injects malicious scripts into a URL from the web application, and the user inadvertently executes it when clicked. </p>

        <a href="{{route('xss_reflect_out')}}"><button class="buttons">Read More ></button></a>

    </div>

    <div class="sub_description" style="background-image: url('images/code.png'); background-size: 285.11px 142.56px;">

        <h3 style="margin-top: 0px">DOM-based XSS</h3>

        <p>DOM-based XSS involves client-side scripts manipulating the Document Object Model (DOM) of a webpage in order to execute malicious code in the browser.</p>

        <a href="{{route('xss_dom_out')}}"><button class="buttons">Read More ></button></a>

    </div>

</div>

<br>

<div class="description">

    <div class="sub_description" style="background-image: url('images/prevention.png'); background-size: 150px 200px;  padding: 30px;">

        <h3 style="margin-top: 0px">XSS Prevention Measures</h3>

        <p>We have design a two-layer architecture which aims to guide developrs into creating a secure environment safe from XSS attacks.</p>

        <a href="{{route('xss_prevention_out')}}"><button class="buttons">Find out how you can protect yourself from XSS Vulnerabilities ></button></a>

    </div>

    <div class="sub_description" style="background-image: url('images/quiz.png'); background-size: 200px 200px; padding: 30px;">

        <h3 style="margin-top: 0px">Take a short quiz!</h3>

        <p>With the help of this short quiz, you can test your knowledge of XSS and see how well you do!</p>

        <a href="{{route('xss_quiz_out')}}"><button class="buttons">Take the Quiz! ></button></a>
        
        </div>

</div>

</div>


</body>
</html> 

@endauth

@endif