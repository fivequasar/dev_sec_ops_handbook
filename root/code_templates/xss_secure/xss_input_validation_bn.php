<?php

function validateUsername($username)
{
    //Defining a whitelist of allowed characters
    $allowedCharacters = '/^[a-z0-9]+$/';

    if (preg_match($allowedCharacters, $username)) {
        echo 'Valid input';
        return true;
    } else {
        echo 'Invalid input';
        return false;
    }
}

$userInput = ""; //Change the input to test it
$isValid = validateUsername($userInput);

?>