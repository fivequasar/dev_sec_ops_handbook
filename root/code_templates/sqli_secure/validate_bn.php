<?php
$input = "";

if (preg_match('/^2\d{4}[ABC]$/', $input)) {
    echo "Input Approved";
} else {
    echo "Input Not Approved";
}
?>