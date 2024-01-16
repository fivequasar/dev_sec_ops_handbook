<?php

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Prox

$server = 'localhost';
$username = 'root';
$password = '';

$conn = new mysqli($server, $username, $password);
$conn->query("DROP USER IF EXISTS 'sandbox_user'@'localhost'");
$conn->query("DROP DATABASE IF EXISTS sample_db");
$conn->query("CREATE DATABASE IF NOT EXISTS sample_db");
$conn->query("CREATE USER IF NOT EXISTS 'sandbox_user'@'localhost' IDENTIFIED BY 'password'");
$conn->query("GRANT SELECT, INSERT, UPDATE, DELETE ON sample_db.* TO 'sandbox_user'@'localhost'");
$conn->select_db("sample_db");
$conn->query("CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20))");
$conn->query("INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia')");
$conn->query("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(50))");
$conn->query("INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')");
$conn->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20))");
$conn->query("INSERT INTO users (username, password) VALUES ('administrator', 'password')");
$conn->close();

?>
