<?php

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0"); 

$server = 'localhost';
$username = 'root';
$password = '';
$db = session('db');
$conn = new mysqli($server, $username, $password, $db);
$conn->query("DROP TABLE IF EXISTS products");
$conn->query("DROP TABLE IF EXISTS comments");
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20))");
$conn->query("INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia')");
$conn->query("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(120))");
$conn->query("INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')");
$conn->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20))");
$conn->query("INSERT INTO users (username, password) VALUES ('administrator', 'password')");
$conn->close();

?>