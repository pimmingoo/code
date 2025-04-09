<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project3"; // Vervang door jouw database naam

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
echo "Verbinding succesvol!";
?>
