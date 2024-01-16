<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=doc, initial-scale=1.0">
    <title>Messages Review</title>
</head>

<body>
  
    <div style="max-width: 400px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; text-align: center;">
    <h1>Comment Time!</h1>
        <form method="post" action="code_templates/xss_stored/stored_xss_ins_bn.php">
            <input type="text" name="message">
            <input type="submit" value="Submit">
        </form>
        <br>
        <a href="code_templates/xss_stored/stored_xss_bn.php"><button>View Messages</button></a>
    </div>

    
</body>

</html>