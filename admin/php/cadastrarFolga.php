<?php
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Recebe os dados do formulário
$idFuncionario = $_POST['idFuncionario'];
$dataFolga = $_POST['dataFolga'];
$tipo = $_POST['tipo'];

// Insere a Folga no banco de dados
$sql = "INSERT INTO folgas (idFuncionario, dataFolgas, tipo) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iss', $idFuncionario, $dataFolga, $tipo);

if (mysqli_stmt_execute($stmt)) {
    // Redireciona para a página de listagem com o idFuncionario via POST
    echo '<form id="redirectForm" action="listaFolgas.php" method="post">
            <input type="hidden" name="idFuncionario" value="' . $idFuncionario . '">
          </form>';
    echo '<script>document.getElementById("redirectForm").submit();</script>';
    exit();
} else {
    echo "Erro ao registrar a Folga: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
