<?php

$server = 'localhost:3307';
$username = 'root';
$password = '';
// $database = 'php_login_database';
$database = 'formulariophp';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
  
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>