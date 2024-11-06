<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Obter o ID do funcionário a partir do POST
$idFuncionario = isset($_POST['idFuncionario']) ? $_POST['idFuncionario'] : null;
$idDepartamento = isset($_POST['idDepartamento']) ? $_POST['idDepartamento'] : null;

// Verifique se o ID do funcionário foi passado
if ($idFuncionario) {
    // Consulta para buscar todas as Folgas do funcionário específico
    $sql = "SELECT * FROM folgas WHERE idFuncionario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idFuncionario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Consulta para contar o total de folgas
    $sqlTotal = "SELECT COUNT(*) AS totalFolgas FROM folgas WHERE idFuncionario = ?";
    $stmtTotal = mysqli_prepare($conn, $sqlTotal);
    mysqli_stmt_bind_param($stmtTotal, 'i', $idFuncionario);
    mysqli_stmt_execute($stmtTotal);
    $resultTotal = mysqli_stmt_get_result($stmtTotal);
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $totalFolgas = $rowTotal['totalFolgas'];
} else {
    echo "ID do funcionário não especificado.";
    exit;
}

// Array para traduzir os tipos de folga
$tiposDeFolga = [
    'folga_semanal' => 'Folga Semanal',
    'folga_compensatoria' => 'Folga Compensatória',
    'folga_remunerada' => 'Folga Remunerada',
    'folga_feriado' => 'Folga para Feriado',
    'licenca_saude' => 'Licença de Saúde',
    'licenca_maternidade' => 'Licença Maternidade',
    'licenca_paternidade' => 'Licença Paternidade',
    'folga_tratamento_saude' => 'Folga para Tratamento de Saúde',
    'licenca_temporaria' => 'Licença Temporária',
    'folga_fim_semana' => 'Folga de Fim de Semana'
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Folgas</title>
    <link rel="stylesheet" href="../css/lista.css"> <!-- Link para o CSS externo -->
</head>

<body>
<nav>
    <form action="listaFuncionario.php" method="post" style="display: inline;">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento ; ?>">
        <button type="submit">Voltar</button>
    </form>
</nav>

<h1>Lista de Folgas</h1>
<h1>Total de Folgas: <?php echo $totalFolgas; ?></h1>
<div>
    <form action="cadastroFolga.php" method="post">
        <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario; ?>">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <button type="submit">Cadastrar Nova Folga </button>
    </form>
</div>   <!-- Exibe o total de Folgas -->

<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Data da Folga</th>
                    <th>Tipo de folga</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $dataFolga = date('d/m/Y', strtotime($row['dataFolgas']));
            $tipoTraduzido = isset($tiposDeFolga[$row['tipo']]) ? $tiposDeFolga[$row['tipo']] : $row['tipo']; // Traduz o tipo

            echo "<tr>
                    <td>{$dataFolga}</td>
                    <td>{$tipoTraduzido}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma Folga encontrada para este funcionário.";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
