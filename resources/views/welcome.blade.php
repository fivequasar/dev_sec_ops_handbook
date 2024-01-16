@if (Route::has('login'))
    @auth
        <a href="{{ url('/index') }}"><button class="buttons" >Back to Main Page</button></a>
    @else

    @include('layouts.navigation_out')

    <div class="main">

        <div class="description">
    
            <div class="sub_description" style="background-image: url('images/info.png');" > 
        
            <h2 style="margin-top: 0px;">Welcome</h2>
            
                <p>WebSec is dedicated to spreading awareness of common cyberattacks and how to prevent them. Our mission is to ensure that developers are well equipped with skills to protect their website from hackers. Our courses are designed to be easy to understand and follow. We also provide detailed explanation and a live demostration of how the attacks work. </p>     
        
            </div>
        </div>
        
            <br>
        
            <div style="margin-bottom: 0px;padding: 20px 20px 0px 20px;background-color: #111;border-radius: 10px 10px 0px 0px;color: white;"> We will go through two common web vulnerabilities <b>SQL Injections</b> (SQLi) and <b>Cross-Site Scripting</b> (XSS)</div>
        
            <div class="description" style=" border-radius: 0px 0px 10px 10px;">
        
            
                <div class="sub_description" style="background-image: url('images/sqli.png');background-size: 300px 300px;">
                    
                    <h3 style="margin-top: 0px">SQL Injections</h3>
        
                    <p>SQL Injections is when attackers uses malicious SQL commands on inputs to access information about the database or the information within.</p>
    
        
                    <a href="{{route('sqli_home_out')}}"><button class="buttons">Read More ></button></a>
                    
                </div>
        
                <div class="sub_description" style="background-image: url('images/xss.png'); ">
        
                
                
                    <h3 style="margin-top: 0px">Cross Site Scripting (XSS)</h3>
        
                    <p>Cross-site scripting (XSS), is an attack in which an attacker injects malicious executable scripts (Javascript) into the code of a website.</p>
    
        
                    <a href="{{route('xss_home_out')}}"><button class="buttons">Read More ></button></a>
        
                </div>
    
        
            </div>
        
            <br>
        
            <div class="description">
        
                <div class="sub_description" style="background-image: url('images/login.png'); background-size: 315.05px 251.19px;  padding: 30px;">
                    
                    <h3 style="margin-top: 0px;padding-bottom:0px">Already a user? </h3>
        
                    <p style="margin-bottom:0px">Re-log in to your existing account to continue accessing all the features of our website. </p>

                    <br>

                    <a href="{{ route('login') }}"><button class="buttons">Login</button></a>

    
                </div>

                <div class="sub_description" style="background-image: url('images/register.png'); background-size: 315.05px 280.15px;  padding: 30px;">
                    
                    <h3 style="margin-top: 0px;padding-bottom:0px">Enjoy the full experience WebSec has to offer!</h3>
        
                    <p style="margin-bottom:0px">Register here to embark on your journey on becoming a web security expert.</p>

                    <br>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"><button class="buttons">Register</button></a>
                    @endif
    
                </div>
        
            </div>
        
        </div> 
    
    </div>




    @endauth
</div>
@endif