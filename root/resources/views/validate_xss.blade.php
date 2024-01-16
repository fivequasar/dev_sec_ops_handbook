<?php

$server_var = session('server');
$username_var = session('username');
$password_var = session('password');
$db_var = session('db');

$content = file_get_contents('code_templates/sqli_secure/validate_bn.php');

if (isset($_POST["code"])) {

    $code = $_POST["code"];

    $myfile = fopen("code.php", "w") ;
    
    fwrite($myfile, $code);
    
    ob_start();
    
    include 'code.php';
    
    $output = ob_get_contents();
    
    ob_end_clean();
    
    unlink("code.php");

} else {

    $code = $content;
    $output = "";

}

?>

@include('layouts.navigation')

    <div class="main">

    <div class="row">

        <div class="editor_column">

        <form method="post">
            @csrf
                <textarea id="code" name="code"><?php echo $code; ?></textarea>
                <br>
                <input type="submit" value="Run Code >" class="buttons">
        </form>

        <br>

        <b>Using preg_match() for input validation</b>

        <p>Let's analyse the syntax that is required for preg_match() to function</p>

        <span class="code_space">preg_match(<span style="color:red">pattern</span>, <span style="color:red">input</span>)</span>

        <br>
        <br>

        <ol>

            <li><p><span class="code_space"><span style="color:red">pattern</span></span>Define what you're looking for in the text through a specific format.</p></li>

            <li><p><span class="code_space"><span style="color:red">input</span></span> The text you want to check. </p></li>
            

        </ol>

        <p>If the pattern matches the input, it will be 1, if it dosen't it will be 0, which could also be interpreted as true or false.</p>

        <p>In the case of the example above, we place the preg_match function within an if statement. If the results of the preg_match is 1 then it will say "Input Approved", else say "Input Not Approved"</p>

        <p>Within the pattern syntax, notice that regular expression (regex) is used, regex allows complex search patterns to be defined using symbols. A regex pattern are surrounded by //, this is an indicator to tell preg_match where the matching starts and ends. Inbetween the slashes are where the actual pattern are specified.</p>

        <p>Within the slashes, the actual pattern is specified. From the example above, the patterns specified are as follows</p>

        <ol>

            <li><p><span class="code_space">^2</span> The digit should always start with 2</p></li>
            <li><p><span class="code_space">\d{4}</span> 4 characters after should be digits of any number</p></li>
            <li><p><span class="code_space">[ABC]$</span> Last character should be either A B or C </p></li>

        </ol>

        <p>So valid inputs could be: (Feel free to copy over the text to the input variable)</p> 

        <span class="code_space">21974A</span> <button class="buttons" onclick="copyTextOne()">Copy</button>
            
        <p>But not:</p>

        <span class="code_space">7AS@SZ</span> <button class="buttons" onclick="copyTextTwo()">Copy</button>

        <p>For more information on regex please go to: <a href="https://regexr.com/">https://regexr.com/</a></p>

        <p><b>Conclusion: </b>Through this way of validation, you can approve what type of data that is accepted and proceed to query or else let the user know that the input is invalid.</p>

        </div>

        <div class="output_column code_font"><?php echo $output; ?></div>
        
    </div>

    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            theme: "ayu-dark"
        });

        
        editor.setSize(null, '200px'); 

        function copyTextOne() {
            var copyText = "29999A";
            navigator.clipboard.writeText(copyText);
        }

        function copyTextTwo() {
            var copyText = "7AS@SZ";
            navigator.clipboard.writeText(copyText);
        }
    </script>
    
    </div>

