<?php

// Tikrinam ar ivestas vardas
if (empty($_POST["name"])) {
    die("Name is required");
}

// Tikrinam ar tinkamas el. pasto adresas
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

// Tikrinam ar slaptazodi sudaro bent 8 simboliai

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

// Tikrinam ar yra panaudota bent viena raide
if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

// Tikrinam ar yra panaudotas bent vienas skaicius
if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

// Tikrinam ar sutampa slaptazodziai
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// Slaptazodzio uzsifravimas
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Pareikalavimas database.php failo
$mysqli = require __DIR__ . "/database.php";

// Pridedam nauja sql irasa
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Pririsamos reiksmes
$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);

// Tikriname ar pavyko prisijungti
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
   
// Tikriname klaidas     
} else {
                    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}