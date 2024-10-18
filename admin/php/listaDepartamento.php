<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Consulta para buscar todos os departamentos e contar o número de funcionários em cada um
$sql = "SELECT d.*, COUNT(f.idFuncionario) AS totalFuncionarios 
        FROM departamento d 
        LEFT JOIN funcionario f ON d.idDepartamento = f.idDepartamento 
        GROUP BY d.idDepartamento";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Departamentos</title>
    <br>
    
    <link rel="stylesheet" href="../css/lista.css"> <!-- Link para o CSS externo -->
</head>

<body>


<h1>Lista de Departamentos</h1>
<form id="cadastroDepartamentoForm" action="cadastroDepartamento.php" method="post" style="display: inline;">
    <button type="submit">Cadastrar Departamento</button>
</form>

<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    
                    <th>Nome do Departamento</th>
                    <th>Total de Funcionários</th>
                    <th></th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    
                    <td>{$row['nomeDepartamento']}</td>
                    <td>{$row['totalFuncionarios']}</td>
                    <td>
                        <form action='listaFuncionario.php' method='post'>
                            <input type='hidden' name='idDepartamento' value='{$row['idDepartamento']}'>
                            <button type='submit'>Ver Funcionários</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum departamento encontrado.";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
