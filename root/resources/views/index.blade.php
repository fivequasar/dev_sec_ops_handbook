@include('db_reset')

@include('layouts.navigation')

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

    
                <a href="{{route('sqli_home')}}"><button class="buttons">Read More ></button></a>
                
            </div>
    
            <div class="sub_description" style="background-image: url('images/xss.png'); ">
    
            
            
                <h3 style="margin-top: 0px">Cross Site Scripting (XSS)</h3>
    
                <p>Cross-site scripting (XSS), is an attack in which an attacker injects malicious executable scripts (Javascript) into the code of a website.</p>

    
                <a href="{{route('xss_home')}}"><button class="buttons">Read More ></button></a>
    
            </div>

    
        </div>
    
        <br>
    
        <div class="description">
    
            <div class="sub_description" style="background-image: url('images/badge.png'); background-size: 251.55px 332.49px;  padding: 30px;">
                
                <h3 style="margin-top: 0px;padding-bottom:0px">Get Certified!</h3>
    
                <p style="margin-bottom:0px">To claim your certificate you need to first pass both the SQLi and XSS quizzes, when you pass you will see a (&#10004) beside the respective quiz. Once all quizzes are completed, a final quiz will be opened for you, and when you pass you will receive a certificate of completion.  View below to track your progress:</p>

                @if (Auth::user()->sqli == 1 && Auth::user()->xss == 1)

    <div style="display:flex;">

        <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #c2d94c;padding: 10px;border-radius: 10px 0px 0px 10px;text-align: center;color: #375200;"><b>SQLi Quiz Status:</b> Completed</p>

        <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #c2d94c;padding: 10px;border-radius: 0px 10px 10px 0px;text-align: center;color: #375200;"><b>XSS Quiz Status:</b> Completed</p>
    </div>
    <br>
    <a href=""><button class="buttons" style="width: 100%;">Take The Certification Quiz ></button></a>
@else
    
    <div style="display:flex;">
        @if (Auth::user()->sqli == 1)
            <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #c2d94c;padding: 10px;border-radius: 10px 0px 0px 10px;text-align: center;color: #375200;"><b>SQLi Quiz Status:</b> Completed</p>
        @else
            <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #5b0303;padding: 10px;border-radius: 10px 0px 0px 10px;text-align: center;color: #ff4040;"><b>SQLi Quiz Status:</b> Not Completed</p>
        @endif
    
        @if (Auth::user()->xss == 1)
            <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #c2d94c;padding: 10px;border-radius: 0px 10px 10px 0px;text-align: center;color: #375200;"><b>XSS Quiz Status:</b> Completed</p>
        @else
            <p style="font-size: 20px;margin-bottom: 0px;flex: 1;background-color: #5b0303;padding: 10px;border-radius: 0px 10px 10px 0px;text-align: center;color: #ff4040;"><b>XSS Quiz Status:</b> Not Completed</p>
        
@endif
</div>
@endif
              
    
    
    
            </div>
    
        </div>
    
    </div> 

</div>
