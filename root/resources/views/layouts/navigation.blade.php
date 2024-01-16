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

    <a href="{{ route('index') }}" @if(url()->current() == route('index')) style="background-color: #ffffff; color: #111;" @endif>
         Home
     </a>

     <a href="{{ route('sqli_home') }}" @if(url()->current() == route('sqli_home')) style="background-color: #ffffff; color: #111;" @endif>
         SQL Injection
     </a>

     <a href="{{ route('in_band') }}" @if(url()->current() == route('in_band') || url()->current() == route('in_band_front_end')  || url()->current() == route('in_band_back_end') || url()->current() == route('in_band_front_union_end') || url()->current() == route('in_band_back_union_end'))  style="background-color: #ffffff; color: #111;" @endif>
         In-Band SQLI
     </a>

     <a href="{{ route('blind') }}" @if(url()->current() == route('blind') || url()->current() == route('blind_front_end') || url()->current() == route('blind_back_end') || url()->current() == route('blind_time_front_end') || url()->current() == route('blind_time_back_end')) style="background-color: #ffffff; color: #111;" @endif>
         Blind SQLI
     </a>

     <a href="{{ route('oob') }}" @if(url()->current() == route('oob')) style="background-color: #ffffff; color: #111;" @endif>
         OOB SQLI
     </a>

     <a href="{{ route('sqli_prevention') }}" @if(url()->current() == route('sqli_prevention') || url()->current() == route('validate_sqli') || url()->current() == route('prepared') || url()->current() == route('sql_secure_front_end')  || url()->current() == route('sql_secure_back_end') ) style="background-color: #ffffff; color: #111;" @endif>
         SQLI Prevention
     </a>

     <a href="{{ route('sql_quiz') }}" @if(url()->current() == route('sql_quiz')) style="background-color: #ffffff; color: #111;" @endif>
        @if(Auth::user()->sqli == 1)
         SQLI Quiz &#10004
        @elseif(Auth::user()->sqli == 0)
         SQLI Quiz
        @endif
     </a>

     <a href="{{ route('xss_home') }}"  @if(url()->current() == route('xss_home')) style="background-color: #ffffff; color: #111;" @endif>
         XSS
     </a>

     <a href="{{ route('xss_stored') }}" @if(url()->current() == route('xss_stored') || url()->current() == route('stored_front_end') || url()->current() == route('submit_back_end') || url()->current() == route('view_back_end')) style="background-color: #ffffff; color: #111;" @endif>
         Stored XSS
     </a>

     <a href="{{ route('xss_reflect') }}" @if(url()->current() == route('xss_reflect') || url()->current() == route('reflect_front_end') || url()->current() == route('reflect_back_end')) style="background-color: #ffffff; color: #111;" @endif>
         Reflected XSS
     </a>

     <a href="{{ route('xss_dom') }}" @if(url()->current() == route('xss_dom') || url()->current() == route('dom_front_end') || url()->current() == route('dom_back_end') ) style="background-color: #ffffff; color: #111;" @endif>
        DOM XSS
     </a>

     <a href="{{ route('xss_prevention') }}" @if(url()->current() == route('xss_prevention') || url()->current() == route('encoding')  || url()->current() == route('validate_xss') || url()->current() == route('xss_secure_front_end')  || url()->current() == route('xss_secure_view_back_end')  || url()->current() == route('xss_secure_submit_back_end')) style="background-color: #ffffff; color: #111;" @endif>
        XSS Prevention
     </a>

     <a href="{{ route('xss_quiz') }}" @if(url()->current() == route('xss_quiz')) style="background-color: #ffffff; color: #111;" @endif>
        @if(Auth::user()->xss == 1)
        XSS Quiz &#10004
        @elseif(Auth::user()->xss == 0)
        XSS Quiz
        @endif
     </a>


    <a style="background-color: #111; cursor: context-menu; padding: 10px 0px 0px 0px;" href="{{route('profile.edit')}}"><button class="buttons" style="margin-left: 10%; margin-right: 10%;width:80%;">Edit Profile</button></a>


                <br>

                <form style="margin-bottom: 0px;font-size: 17px;" method="POST" action="{{ route('logout') }}" >
                    @csrf
                    <input type="submit" value="Logout" class="buttons" style="margin-left: 10%; margin-right: 10%;width:80%;">
                </form>

    </div>
</body>
