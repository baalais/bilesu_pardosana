<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bilesu_pardosana";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Savienojuma kļūda: " . $conn->connect_error);
}
?>