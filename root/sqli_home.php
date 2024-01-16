<!DOCTYPE html>

<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/style.css">

    </head>
<body>

<?php include 'navigation.php'; ?>

<div class="main">

<div class="description">

    <div class="sub_description" style="background-image: url('images/info.png');" > 

    <h2 style="margin-top: 0px;">SQL Injection</h2>
    
        <p><b>Description:</b> SQL Injection, otherwise known as SQLI, is a type of injection where a malicious actor uses a SQL command on any website that require data input. Based on the predefined SQL commands configured behind the application, the attacker can potentially change the results of the execution based on the commands send over from the attacker to the application. If an attack is successful, an attacker can cause damage to the database by exposing data, modifying data, destroying data, cause repudiation issues and potentially get granted administrative privileges of the database.</p>     

    </div>
</div>

    <br>

    <div style="margin-bottom: 0px;padding: 20px 20px 0px 20px;background-color: #111;border-radius: 10px 10px 0px 0px;color: white;"> SQL Injections are split into three main categories, In-band, Out-of-band and Blind SQLi.</div>

    <div class="description" style=" border-radius: 0px 0px 10px 10px;">

    

        <div class="sub_description" style="background-image: url('images/in_band.png');">
            
            <h3 style="margin-top: 0px">In-Band</h3>

            <p>Being the most common type of SQLi attack, the attacker launches and obtains the results of the attack on the same communication path. </p>

            <a href="sqli_in_band.php"><button class="buttons">Read More ></button></a>

        </div>

        <div class="sub_description" style="background-image: url('images/blind.png'); background-size: 300px 262.11px;">

        
        
            <h3 style="margin-top: 0px">Blind</h3>

            <p>An attacker sends a payload over and based on the results and reaction given by the server, then proceeds to build a profile on the architecture of the database. </p>

            <a href="sqli_blind.php"><button class="buttons">Read More ></button></a>

        </div>

        <div class="sub_description" style="background-image: url('images/out_of_band.png');">

            <h3 style="margin-top: 0px">Out-Of-Band</h3>

            <p>Where in-band and blind SQLi both receives some form of response back to the attacker, out-of-band SQL Injections sends the response to an attacker's remote endpoint.</p> 

            <a href="sqli_oob.php"><button class="buttons">Read More ></button></a>
        
        </div>

    </div>

    <br>

    <div class="description">

        <div class="sub_description" style="background-image: url('images/prevention.png'); background-size: 150px 200px;  padding: 30px;">
            
            <h3 style="margin-top: 0px">SQLi Prevention Measures</h3>

            <p>We have design a two-layer architecture which aims to guide developrs into creating a secure environment safe from SQLi attacks.</p>

            <a href="sqli_prevention.php"><button class="buttons">Find out how you can protect yourself from SQLi Vulnerabilities ></button></a>

        </div>

    </div>

</div> 

</div>
</body>
</html> 
