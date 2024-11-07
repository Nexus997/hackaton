<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Folgas</title>
    <link rel="stylesheet" href="../css/cadastro.css">  
    <link rel="icon" href="../img/Admin+logo.png" type="image/x-icon">
</head>
<body>
<nav class="voltar">
    <form action="listaFolgas.php" method="post" style="display: inline;">
        <input type="hidden" name="idDepartamento" value="<?php echo ($_POST['idDepartamento']); ?>">
        <input type="hidden" name="idFuncionario" value="<?php echo ($_POST['idFuncionario']); ?>">
        <button class="voltarBtn" type="submit">Voltar</button>
    </form>
</nav>
    <h1>Cadastro de Folgas</h1>

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

    <form method="POST" action="cadastrarFolga.php">
        <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario; ?>">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">

        <label for="dataFolga">Data da Folga:</label>
        <input type="date" id="dataFolga" name="dataFolga" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
  <option value="folga_semanal">Folga Semanal</option>
  <option value="folga_compensatoria">Folga Compensatória</option>
  <option value="folga_remunerada">Folga Remunerada</option>
  <option value="folga_feriado">Folga para Feriado</option>
  <option value="licenca_saude">Licença de Saúde</option>
  <option value="licenca_maternidade">Licença Maternidade</option>
  <option value="licenca_paternidade">Licença Paternidade</option>
  <option value="folga_tratamento_saude">Folga para Tratamento de Saúde</option>
  <option value="licenca_temporaria">Licença Temporária</option>
  <option value="folga_fim_semana">Folga de Fim de Semana</option>
</select>
<br><br>

        <button type="submit">Registrar Folga</button>
    </form>
</body>
</html>
