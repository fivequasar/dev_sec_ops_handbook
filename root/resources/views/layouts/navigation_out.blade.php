<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="codemirror/ayu-dark.css">
    <script src="{{ asset('codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('codemirror/matchbrackets.js') }}"></script>
    <script src="{{ asset('codemirror/htmlmixed.js') }}"></script>
    <script src="{{ asset('codemirror/xml.js') }}"></script>
    <script src="{{ asset('codemirror/javascript.js') }}"></script>
    <script src="{{ asset('codemirror/css.js') }}"></script>
    <script src="{{ asset('codemirror/clike.js') }}"></script>
    <script src="{{ asset('codemirror/php.js') }}"></script>

</head>
<body>

<div class="vertical-menu">

    <a href="{{route('welcome')}}" @if(url()->current() == route('welcome')) style="background-color: #ffffff; color: #111;" @endif>
         Home
     </a>

     <a href="{{route('sqli_home_out')}}" @if(url()->current() == route('sqli_home_out')) style="background-color: #ffffff; color: #111;" @endif>
         SQL Injection
     </a>

     <a href="{{route('sqli_in_band_out')}}" @if(url()->current() == route('sqli_in_band_out') || url()->current() == route('in_band_front_end')  || url()->current() == route('in_band_back_end') || url()->current() == route('in_band_front_union_end') || url()->current() == route('in_band_back_union_end'))  style="background-color: #ffffff; color: #111;" @endif>
         In-Band SQLI
     </a>

     <a href="{{route('sqli_blind_out')}}" @if(url()->current() == route('sqli_blind_out') || url()->current() == route('blind_front_end') || url()->current() == route('blind_back_end') || url()->current() == route('blind_time_front_end') || url()->current() == route('blind_time_back_end')) style="background-color: #ffffff; color: #111;" @endif>
         Blind SQLI
     </a>

     <a href="{{route('sqli_oob_out')}}" @if(url()->current() == route('sqli_oob_out')) style="background-color: #ffffff; color: #111;" @endif>
         OOB SQLI
     </a>

     <a href="{{route('sqli_prevention_out')}}" @if(url()->current() == route('sqli_prevention_out') ) style="background-color: #ffffff; color: #111;" @endif>
         SQLI Prevention
     </a>

     <a href="{{route('sqli_quiz_out')}}" @if(url()->current() == route('sqli_quiz_out')) style="background-color: #ffffff; color: #111;" @endif>SQLi Quiz</a>


     <a href="{{route('xss_home_out')}}"  @if(url()->current() == route('xss_home_out')) style="background-color: #ffffff; color: #111;" @endif>
         XSS
     </a>

     <a href="{{route('xss_stored_out')}}" @if(url()->current() == route('xss_stored_out')) style="background-color: #ffffff; color: #111;" @endif>
         Stored XSS
     </a>

     <a href="{{route('xss_reflect_out')}}" @if(url()->current() == route('xss_reflect_out')) style="background-color: #ffffff; color: #111;" @endif>
         Reflected XSS
     </a>

     <a href="{{route('xss_dom_out')}}" @if(url()->current() == route('xss_dom_out') ) style="background-color: #ffffff; color: #111;" @endif>
        DOM XSS
     </a>

     <a href="{{route('xss_prevention_out')}}" @if(url()->current() == route('xss_prevention_out') ) style="background-color: #ffffff; color: #111;" @endif>
        XSS Prevention
     </a>

     <a href="{{route('xss_quiz_out')}}" @if(url()->current() == route('xss_quiz_out')) style="background-color: #ffffff; color: #111;" @endif>XSS Quiz</a>


    <a style="background-color: #111; cursor: context-menu; padding: 10px 0px 0px 0px;" href="{{ route('login') }}"><button class="buttons" style="margin-left: 10%; margin-right: 10%;width:80%;">Log in</button></a>
     <br>
    @if (Route::has('register'))
        <a style="background-color: #111; cursor: context-menu; padding: 00px 0px 0px 0px;" href="{{ route('register') }}"><button class="buttons" style="margin-left: 10%; margin-right: 10%;width:80%;">Register</button></a>
    @endif

    </div>
</body>
