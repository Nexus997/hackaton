<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Faltas</title>
    <link rel="stylesheet" href="../css/cadastro.css">  
    <link rel="icon" href="../img/Admin+logo.png" type="image/x-icon">
</head>
<body>
<nav class="voltar">
    <form action="listaFaltas.php" method="post" style="display: inline;">
        <input type="hidden" name="idDepartamento" value="<?php echo ($_POST['idDepartamento']); ?>">
        <input type="hidden" name="idFuncionario" value="<?php echo ($_POST['idFuncionario']); ?>">
        <button class="voltarBtn" type="submit">Voltar</button>
    </form>
</nav>
    <h1>Cadastro de Faltas</h1>

    <?php
    // Conexão com o banco de dados
    require_once('conn.php');
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

    // Obter o ID do funcionário passado por POST
    $idFuncionario = isset($_POST['idFuncionario']) ? $_POST['idFuncionario'] : null;
    $idDepartamento = isset($_POST['idDepartamento']) ? $_POST['idDepartamento'] : null;

    // Verificar se o ID do funcionário foi passado
    if ($idFuncionario) {
        // Consulta para obter o nome do funcionário
        $sql = "SELECT f.nome, d.nomeDepartamento FROM funcionario f 
                LEFT JOIN departamento d ON f.idDepartamento = d.idDepartamento 
                WHERE f.idFuncionario = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $idFuncionario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Verificar se o funcionário foi encontrado
        if ($row = mysqli_fetch_assoc($result)) {
            $nomeFuncionario = $row['nome'];
            $nomeDepartamento = $row['nomeDepartamento'];
        } else {
            echo "Funcionário não encontrado.";
            exit;
        }
    } else {
        echo "ID do funcionário não especificado.";
        exit;
    }

    mysqli_close($conn);
    ?>

    <p>Funcionário: <strong><?php echo $nomeFuncionario; ?> - <?php echo $nomeDepartamento; ?></strong></p>

    <form method="POST" action="cadastrarFalta.php">
        <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario; ?>">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">

        <label for="dataFalta">Data da Falta:</label>
        <input type="date" id="dataFalta" name="dataFalta" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="motivo">Motivo:</label>
        <textarea id="motivo" name="motivo" required></textarea><br><br>

        <button type="submit">Registrar Falta</button>
    </form>
</body>
</html>
