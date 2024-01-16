<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="max-width: 400px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; text-align: center;">

        <h1>Product Search</h1>

        <form method="get" action="code_templates/xss_reflected/reflected_xss_fn_bn.php">
            <label for="name">Product name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <br>
            <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
            <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
            <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
            <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
            <br>
            <input type="submit" value="Submit">
        </form>

    </div>
</body>
</html>
