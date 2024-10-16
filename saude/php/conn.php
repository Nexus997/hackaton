<?php



$servername = "localhost:3308";
$username = "root";
$password = "etec2024";
$dbname = "hackatonsaude";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>