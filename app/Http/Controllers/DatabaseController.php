<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class DatabaseController extends Controller
{
    public function setSessionAndRedirect(Request $request) {


        function append_string ($str1, $str2) { 
    
            $str1 .=$str2; 

            return $str1; 
        }

        function getRandomString($n)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }

            return $randomString;
        }

        $password = getRandomString(20);

        $unq = uniqid();

        $char = chr(rand(97,122));

        $name = append_string($char, $unq); 

        DB::statement("CREATE DATABASE IF NOT EXISTS " . $name . "_db");
        DB::statement("CREATE USER IF NOT EXISTS '" . $name . "_user'@'localhost' IDENTIFIED BY '" . $password ."'");
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON `" . $name . "_db`.* TO '" . $name . "_user'@'localhost'");

        config(['database.connections.mysql.database' => $name . "_db"]);
        DB::purge('mysql');
        DB::setDefaultConnection('mysql');

        DB::statement("CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), country VARCHAR(20))");
        DB::statement("INSERT INTO products (name, country) VALUES ('Apples', 'Spain'), ('Bananas', 'South Africa'), ('Cheese', 'France'), ('Dragonfruit', 'Indonesia')");
        DB::statement("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(120))");
        DB::statement("INSERT INTO comments (message) VALUES ('Hello!'), ('HI'), ('Heyyyy'), ('Evening')");
        DB::statement("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20) UNIQUE, password VARCHAR(20))");
        DB::statement("INSERT INTO users (username, password) VALUES ('administrator', 'password')");

        //session(['server' => 'localhost']);
        $request->session()->put('server', 'localhost');

        //session(['username' => ''. $name .'_user']);
        $request->session()->put('username', ''. $name .'_user');

        //session(['password' => 'password']);
        $request->session()->put('password', $password);

        //session(['db' => ''. $name .'_db']);
        $request->session()->put('db', ''. $name .'_db');


        return redirect()->route('index');
    }

    }




