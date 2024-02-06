<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ex_crud_brg2";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
