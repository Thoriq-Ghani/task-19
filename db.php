<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'task19';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}
?>
