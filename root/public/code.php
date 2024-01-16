<?php
$username = "<script>alert('XSS')</script>";
$encodedUsername = htmlspecialchars($username, ENT_QUOTES);
echo "Hello, " . $encodedUsername . "!";
?>