<?php
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Recebe os dados do formulário
$idFuncionario = $_POST['idFuncionario'];
$dataFalta = $_POST['dataFalta'];
$motivo = $_POST['motivo'];

// Insere a falta no banco de dados
$sql = "INSERT INTO faltas (idFuncionario, dataFalta, motivo) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iss', $idFuncionario, $dataFalta, $motivo);

if (mysqli_stmt_execute($stmt)) {
    echo "Falta registrada com sucesso.";
} else {
    echo "Erro ao registrar a falta: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redireciona para a página de listagem ou um feedback
header('Location: listaFaltas.php'); // Supondo que você tenha uma página para listar as faltas
exit();
?>
