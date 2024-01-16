<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You Have Been Phished</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #e74c3c;
        }
        p {
            font-size: 18px;
            margin-top: 20px;
        }
        .buttons {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: 2px solid #e74c3c;
            border-radius: 5px;
            color: #ffffff;
            background-color: #e74c3c;
            transition: background-color 0.3s, color 0.3s;
        }

        .buttons:hover {
            background-color: #ffffff;
            color: #3498db;
        }
    </style>
</head>
<body>
    <h1>You Have Been Phished</h1>
    <p>This is a simulated phishing attempt. This is one of the effects of Stored Cross Site Scripting.</p>
    <p>Read more about the Stored Cross Site Scripting and its side effects <a href="https://brightsec.com/blog/stored-xss/">here</a>.</p>
    
    <a href="/root/stored_xss.php" class="button-link">
        <button class="buttons">Return back to Stored Cross Site Scripting Simulation</button>
    </a>
</body>
</html>