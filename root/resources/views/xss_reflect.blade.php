@include('db_reset')

@include('layouts.navigation')

<div class="main">

    <div class="description" style="border-radius: 10px 10px 0px 0px; padding: 10px 10px 0px 10px;">

<div class="sub_description" style="background-image: url('images/reflect.png'); background-size: 250px 250px;">

    <h2 style="margin-top: 0px;">Reflected XSS</h2>

    <p><b>Description: </b>Reflected XSS is when an attacker attaches a payload to a URL from a web application which will then be sent to the victim. The payload is not stored in the website, however it requires user's interaction as the payload only can activate when a user clicks on it.</p>
</div>



</div>

<div class="description" style="border-radius: 0px; padding: 0px 10px 0px 10px;">

<div class="sub_description" style="background-image: url('images/example.png'); margin: 10px 15px 10px 15px; background-size: 192.53px 224.66px;">

    <p style="margin-top: 0px;"><b>Example: </b> A search function for a product. The user can choose to read more about a specific product by searching for the name of it.</p>

    

    <ol id="list">

        <li>Say a user searches for the product “apple”, the URL will look like this:</li>

        <br>
        <span class="code_space">https://example.com/search?product=apple</span>
        <br>
        <br>
        
        <li>This will return details of the product apple like:</li>

        <p class="code_space" style="margin-bottom: 0px;">
            <b>Result:</b> <br>
            Name: Apple <br>
            Price: 2.99 <br>
            Quantity: 455
        </p>

        </ol>


        <button class="buttons" id="readMore" onclick="toggle()">Read More</button>

        <div id="road">

        <ol start="3">

        

        <li>However, when a user enters a product that can't be found, it will reflect the user's input and say that it's not found. Say a user searches for the product “Hello!”, the URL will look like this:</li>

        <br>
        <span class="code_space">https://example.com/search?product=Hello!</span>
        <br>
        <br>

        <li>As the user supplied input is completely out of context, the website can't find the product named “Hello”, it will proceed to show:</li>

        <br>
        <span class="code_space">The product named “Hello” cannot be found.</span>
        <br>
        <br>

        <li>The attacker then proceeds to search for the item:</li>

        <br>
        <span class="code_space">&lt;script&gt;alert('XSS')&lt;/script&gt;</span>
        <br>
        <br>

        <li>The URL will now look like:</li>

        <br>
        <span class="code_space">https://example.com/search?product=&lt;script&gt;alert('XSS')&lt;/script&gt;</span>
        <br>
        <br>

        <li>As the product <span class="code_space" style="padding: 2px 10px 2px 10px;">&lt;script&gt;alert('XSS')&lt;/script&gt;</span> can't be found, when acessing the link, it will reflect back to the user:</li>

        <br>
        <span class="code_space">The product named "" cannot be found.</span>
        <br>
        <br>

        <li>The browser will not display the script tag as the browser will see it as an actual script elements and run the contents within. In this case, this will produce a pop-up message on the user's browser with the words “XSS” when the user accesses this link.</li>



    </ol>

        <button class="buttons" id="readLess" onclick="toggleOff()" style="display: none;">Read Less</button>

    </div>

    

    
</div>


</div>

    <div class="description" style="border-radius: 0px 0px 10px 10px; padding: 0px 10px 10px 10px;">
    <div class="sub_description" style="background-image: url('images/con.png'); margin: 10px 15px 10px 15px;background-size: 214.17px 197.67px;">
        <p style="margin-top: 0px; margin-bottom: 0px;"><b>Consequences:</b> In situations where user-supplied data is not properly validated or encoded, and if a web application is able to reflect back the data, attackers can execute reflected attacks.  They can craft a more advanced script within the script tag to potentially steal the user's account and perform any action credited to it. </p>
    </div>

</div>

<br>

<div class="description">

<a href="{{route('reflect_front_end')}}" style="width: 100%;"><button class="buttons" style="width: 100%; text-align:left;padding: 20px;font-size: 20px;">Initiate Reflected XSS Demo ></button></a>

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
document.getElementById("list").style.marginBottom = "0px";

}
function toggleOff() {
var x = document.getElementById("road");
x.classList.toggle('active');
var y = document.getElementById("readMore");
y.style.display = 'block';
var y = document.getElementById("readLess");
y.style.display = 'none';
document.getElementById("list").style.marginBottom = "22px";
}

</script>





