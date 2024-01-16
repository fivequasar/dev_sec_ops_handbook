@include('db_reset')

@include('layouts.navigation')

<div class="main">

    <div class="description">

        <div class="sub_description" style="background-image: url('images/quiz.png');">

            <h2 style="margin-top: 0px;">Cross-site Scripting (XSS) Quiz</h2>

            
            <p>You need to get at least 3 out of 5 correct to complete the quiz.</p>

        
            </div>

            
        </div>

        <br>

        @if(session()->has('status') )

        @if(session()->get('status') == "Completed! Marked as Done!")
    
            <p style="color:#111; background-color: #c6dd54; padding: 26px; border-radius: 12px;margin-top: 0px;">{{session('status')}}</p>
    
        @endif
    
        @if(session()->get('status') == "Try Again")
    
            <p style="color:#ffffff; background-color: #d94c4c; padding: 26px; border-radius: 12px;margin-top: 0px;">{{session('status')}}</p>
    
        @endif
    
        @endif

        <div class="description" style="display: block;">


            <div class="sub_description" style="background-image: url('images/quiz.png');">
    
                <form method="post" action="{{route('xss_quiz_checker')}}">
                @csrf
                <div class="question" id="question1" >
                    <p style="margin-top:0px;"><b>Question 1:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quaerat itaque unde mollitia? Accusantium quia repellat corrupti eos aperiam odio dolor, maxime consequatur vel, quo, ad provident ipsa ut?</p>
                    <input type="hidden" name="q1" value="0">
                    <input type="radio"  name="q1" value="0">
                    <label>Answer</label><br>
                    <input type="radio"  name="q1" value="0">
                    <label>Answer</label><br>  
                    <input type="radio"  name="q1" value="0">
                    <label>Answer</label><br>
                    <input type="radio"  name="q1" value="1">
                    <label>Correct Answer</label><br>
                    
    
                </div>
    
                </div>
    
    
                <div class="sub_description" style="background-image: url('images/quiz.png');">
    
                <div class="question" id="question2">
                    <p style="margin-top:0px;"><b>Question 2:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quaerat itaque unde mollitia? Accusantium quia repellat corrupti eos aperiam odio dolor, maxime consequatur vel, quo, ad provident ipsa ut?</p>
                    <input type="hidden" name="q2[]" value="0">
                    <input type="checkbox"  name="q2[]" value="1">
                    <label>Correct Answer</label><br>
                    <input type="checkbox"  name="q2[]" value="0">
                    <label >Answer</label><br>  
                    <input type="checkbox"  name="q2[]" value="0">
                    <label>Answer</label><br>
                    <input type="checkbox"  name="q2[]" value="1">
                    <label>Correct Answer</label><br>
    
                </div>
    
                </div>
    
                <div class="sub_description" style="background-image: url('images/quiz.png');">
    
                <div class="question" id="question3">
                    <p style="margin-top:0px;"><b>Question 3:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quaerat itaque unde mollitia? Accusantium quia repellat corrupti eos aperiam odio dolor, maxime consequatur vel, quo, ad provident ipsa ut?</p>
                    <input type="hidden" name="q3" value="0">
                    <input type="radio"  name="q3" value="0">
                    <label>Answer</label><br>
                    <input type="radio"  name="q3" value="0">
                    <label>Answer</label><br>  
                    <input type="radio"  name="q3" value="0">
                    <label>Answer</label><br>
                    <input type="radio"  name="q3" value="1">
                    <label>Correct Answer</label><br>
    
                </div>
    
                </div>
    
                <div class="sub_description" style="background-image: url('images/quiz.png');">
    
                <div class="question" id="question4">
                    <p style="margin-top:0px;"><b>Question 4:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quaerat itaque unde mollitia? Accusantium quia repellat corrupti eos aperiam odio dolor, maxime consequatur vel, quo, ad provident ipsa ut?</p>
                    <input type="hidden" name="q4" value="0">
                    <input type="radio" name="q4" value="0">
                    <label>Answer</label><br>
                    <input type="radio" name="q4" value="0">
                    <label>Answer</label><br>  
                    <input type="radio" name="q4" value="0">
                    <label>Answer</label><br>
                    <input type="radio" name="q4" value="1">
                    <label>Correct Answer</label><br>
    
                </div>
    
                </div>
    
                <div class="sub_description" style="background-image: url('images/quiz.png');">
    
                <div class="question" id="question5">
                    <p style="margin-top:0px;"><b>Question 5:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quaerat itaque unde mollitia? Accusantium quia repellat corrupti eos aperiam odio dolor, maxime consequatur vel, quo, ad provident ipsa ut?</p>
                    <input type="hidden" name="q5" value="0">
                    <input type="radio" name="q5" value="0">
                    <label>Answer</label><br>
                    <input type="radio" name="q5" value="0">
                    <label>Answer</label><br>  
                    <input type="radio" name="q5" value="0">
                    <label>Answer</label><br>
                    <input type="radio" name="q5" value="1">
                    <label>Correct Answer</label>
                </div>
    
                
    
                </div>
    
    
    
    
                </div>
    
                <br>
    
    
                <div class="description" style="padding: 10px;">
    
                <input class="buttons" type="submit" value="Submit" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">
    
                </form>
                
            </div>
    </div>

</div>