<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Login</h1>
    <form method="get" action="code_templates/sqli_in_band/sqli_ib_fn_bn.php">
        Username: <input type="text" name="username">
        <br>
        <br>
        Password: <input type="password" name="password">
        <br>
        <br>
        <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
        <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
        <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
        <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>