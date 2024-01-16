<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form to Add Record</title>
</head>
<body>
    <h1>ID Identifier</h1>
    <form method="get" action="code_templates/sqli_blind/sqli_tb_fn_bn.php">
        UserId: <input type="text" name="id" required>
        <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
        <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
        <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
        <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
        <br>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>