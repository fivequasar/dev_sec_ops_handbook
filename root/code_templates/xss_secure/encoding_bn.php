<?php
$username = "";
$encodedUsername = htmlspecialchars($username, ENT_QUOTES);
echo "Hello, " . $encodedUsername . "!";
?>