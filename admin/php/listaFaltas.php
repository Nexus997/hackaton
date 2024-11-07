<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Obter o ID do funcionário a partir do POST
$idFuncionario = isset($_POST['idFuncionario']) ? $_POST['idFuncionario'] : null;
$idDepartamento = isset($_POST['idDepartamento']) ? $_POST['idDepartamento'] : null;

// Verifique se o ID do funcionário foi passado
if ($idFuncionario) {
    // Consulta para buscar todas as faltas do funcionário específico
    $sql = "SELECT * FROM faltas WHERE idFuncionario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idFuncionario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Consulta para contar o total de faltas
    $sqlTotal = "SELECT COUNT(*) AS totalFaltas FROM faltas WHERE idFuncionario = ?";
    $stmtTotal = mysqli_prepare($conn, $sqlTotal);
    mysqli_stmt_bind_param($stmtTotal, 'i', $idFuncionario);
    mysqli_stmt_execute($stmtTotal);
    $resultTotal = mysqli_stmt_get_result($stmtTotal);
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $totalFaltas = $rowTotal['totalFaltas'];
} else {
    echo "ID do funcionário não especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Faltas</title>
    <link rel="stylesheet" href="../css/lista.css"> 
    <link rel="icon" href="../img/Admin+logo.png" type="image/x-icon"><!-- Link para o CSS externo -->
</head>

<body>
<nav>
    <form action="listaFuncionario.php" method="post" style="display: inline;">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <button type="submit">Voltar</button>
    </form>
</nav>

<h1>Lista de Faltas</h1>
<h1>Total de Faltas: <?php echo $totalFaltas; ?></h1>
<div>
    <form action="cadastroFalta.php" method="post">
        <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario; ?>">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <button type="submit">Cadastrar Nova Falta</button>
    </form>
</div>   <!-- Exibe o total de faltas -->

<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    
                    <th>Data da Falta</th>
                    <th>Motivo</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $dataFalta = date('d/m/Y', strtotime($row['dataFalta']));
            echo "<tr>
                    
                    <td>{$dataFalta}</td>
                    <td>{$row['motivo']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma falta encontrada para este funcionário.";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
