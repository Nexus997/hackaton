<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica se idDepartamento foi passado via POST
$idDepartamento = isset($_POST['idDepartamento']) ? intval($_POST['idDepartamento']) : 0;
$sqlDepartamento = "SELECT nomeDepartamento FROM departamento WHERE idDepartamento = ?";
$stmtDepartamento = mysqli_prepare($conn, $sqlDepartamento);
mysqli_stmt_bind_param($stmtDepartamento, 'i', $idDepartamento);
mysqli_stmt_execute($stmtDepartamento);
$resultDepartamento = mysqli_stmt_get_result($stmtDepartamento);
$departamento = mysqli_fetch_assoc($resultDepartamento);

// Consulta para buscar todos os funcionários do departamento específico e contar as faltas
$sql = "SELECT f.*, d.nomeDepartamento, 
               (SELECT COUNT(*) FROM faltas WHERE idFuncionario = f.idFuncionario) AS totalFaltas
        FROM funcionario f 
        LEFT JOIN departamento d ON f.idDepartamento = d.idDepartamento
        WHERE f.idDepartamento = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $idDepartamento);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Funcionários</title>
    <link rel="stylesheet" href="../css/lista.css">
    <link rel="icon" href="../img/Admin+logo.png" type="image/x-icon">
</head>

<body>
<nav>
    <a href="listaDepartamento.php">Voltar</a>
</nav>

<h1>Lista de Funcionários - <?php echo htmlspecialchars($departamento['nomeDepartamento']); ?></h1>

<form id="cadastroFuncionarioForm" action="cadastroFuncionario.php" method="post" style="display: inline;">
    <input type='hidden' name='idDepartamento' value="<?php echo $idDepartamento; ?>">
    <button type="submit">Cadastrar Funcionário</button>
</form>

<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nome</th>
                    <th>Data de Admissão</th>
                    <th>Idade</th>
                    <th>Departamento</th>
                    <th>Contato</th>
                    <th>Salário(R$)</th>
                    <th>Faltas</th>
                    <th>Folgas</th>
                    <th>PLR</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {

            $dataFunc = date('d/m/Y', strtotime($row['dataAdmissao']));
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>$dataFunc</td>
                    <td>{$row['idade']}</td>
                    <td>{$row['nomeDepartamento']}</td>
                    <td>{$row['contato']}</td>
                    <td>{$row['salario']}</td>
                    <td>
                        <form action='listaFaltas.php' method='post' style='display: inline;'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
                            <input type='hidden' name='idDepartamento' value='{$row['idDepartamento']}'>
                            <button type='submit'>Faltas</button>
                        </form>
                    </td>
                    <td>
                        <form action='listaFolgas.php' method='post'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
                            <input type='hidden' name='idDepartamento' value='{$row['idDepartamento']}'>
                            <button type='submit'>Folgas</button>
                        </form>
                    </td>
                    <td>
                        <form action='gerenciar_plr.php' method='post'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
                            <input type='hidden' name='idDepartamento' value='{$row['idDepartamento']}'>
                            <button type='submit'>PLR</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum funcionário encontrado.";
    }

    mysqli_close($conn);
    ?>
</div>


</body>
</html>
