<?php

// Prisijungimo duomenys
$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

// Prisijungimas prie duomenu bazes
$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);

// Tikrinam ar sekmingai prisijungta       
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Grazinamas prisijungimo kintamasis
return $mysqli;
