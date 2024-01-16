<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=doc, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form method="post" action="code_templates/xss_secure/secure_xss_ins_fn_bn.php">
    <input type="text" name="message">
    <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
    <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
    <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
    <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
    <input type="submit" value="Submit">
</form>
<br>

<form method="get" action="code_templates/xss_secure/secure_xss_fn_bn.php">
    <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
    <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
    <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
    <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
    <input type="submit" value="View Messages">
</form>

</body>
</html>
