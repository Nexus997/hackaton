<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Consulta para buscar todos os funcionários com os respectivos departamentos e contar as faltas
$sql = "SELECT f.*, d.nomeDepartamento, 
               (SELECT COUNT(*) FROM faltas WHERE idFuncionario = f.idFuncionario) AS totalFaltas
        FROM funcionario f 
        LEFT JOIN departamento d ON f.idDepartamento = d.idDepartamento";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Funcionários</title>
    <link rel="stylesheet" href="../css/lista.css"> <!-- Link para o CSS externo -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<nav>
    <a href="inicio.php">Voltar</a>
</nav>

<style>
    td {
        max-width: 250px;  /* Largura máxima */
        overflow-wrap: break-word;  /* Quebra de palavras */
        white-space: normal;  /* Permite múltiplas linhas */
    }
</style>

<h1>Lista de Funcionários</h1>
<br> 

<form id="cadastroFuncionarioForm" action="cadastroFuncionario.php" method="post" style="display: inline;">
    <button type="submit">Cadastrar Funcionário</button>
</form>
<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Idade</th>
                    <th>Departamento</th>
                    <th>Contato</th>
                    <th>Salário</th>
                    <th>Faltas</th>
                    <th>Folgas</th>
                    <th>PLR</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['dataNasc']}</td>
                    <td>{$row['idade']}</td>
                    <td>{$row['nomeDepartamento']}</td>
                    <td>{$row['contato']}</td>
                    <td>{$row['salario']}</td>
                    
                    <td>
                        <form action='listaFaltas.php' method='post' style='display: inline;'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
                            <button type='submit'>Faltas</button>
                        </form>
                    </td>
                    <td>
                        <form action='gerenciar_folgas.php' method='post'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
                            <button type='submit'>Folgas</button>
                        </form>
                    </td>
                    <td>
                        <form action='gerenciar_plr.php' method='post'>
                            <input type='hidden' name='idFuncionario' value='{$row['idFuncionario']}'>
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
