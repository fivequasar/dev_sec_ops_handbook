<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Product Search</h1>
    <form method="get" action="code_templates/xss_reflect/reflected_xss_fn_bn.php">
        Search: <input type="text" name="name" required>
        <br>
        <br>
        <input type="hidden" name="server_var" value="<?php echo $server_var; ?>">
        <input type="hidden" name="username_var" value="<?php echo $username_var; ?>">
        <input type="hidden" name="password_var" value="<?php echo $password_var; ?>">
        <input type="hidden" name="db_var" value="<?php echo $db_var; ?>">
        <input type="submit" value="Search">
    </form>
</body>
</html>