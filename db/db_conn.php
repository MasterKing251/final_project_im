<?php
session_start();


$host = "localhost";
$dbName = "final_project_im";
$user = "root";
$pass = "";
function pdo_init()
{
    global $host, $dbName,$user, $pass;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        $error = "Errors: {$e->getMessage()}";
    }
}
