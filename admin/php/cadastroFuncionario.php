<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
    <h1>Cadastro de Funcionário</h1>
    <form method="POST" action="cadastrarFuncionario.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="documento">Documento:</label>
        <input type="text" id="documento" name="documento" required><br><br>

        <label for="dataNasc">Data de Nascimento:</label>
        <input type="date" id="dataNasc" name="dataNasc" required><br><br>

        <label for="dataAdmissao">Data de Admissão:</label>
        <input type="date" id="dataAdmissao" name="dataAdmissao" required><br><br>

        <label for="idDepartamento">Departamento:</label>
        <input type="hidden" id="idDepartamento" name="idDepartamento" value="<?php echo isset($_POST['idDepartamento']) ? htmlspecialchars($_POST['idDepartamento']) : ''; ?>">
        <span>
            <?php
            // Conexão com o banco de dados
            require_once('conn.php');
            $conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

            // Pega o nome do departamento correspondente ao ID passado por POST
            $idDepartamento = isset($_POST['idDepartamento']) ? $_POST['idDepartamento'] : null;
            if ($idDepartamento) {
                $sql = "SELECT nomeDepartamento FROM departamento WHERE idDepartamento = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $idDepartamento);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $nomeDepartamento);
                if (mysqli_stmt_fetch($stmt)) {
                    echo htmlspecialchars($nomeDepartamento); // Exibe o nome do departamento
                } else {
                    echo "Departamento não encontrado.";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "ID do departamento não especificado.";
            }
            mysqli_close($conn);
            ?>
        </span><br><br>

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato" required><br><br>

        <label for="salario">Salário:</label>
        <input type="text" id="salario" name="salario" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
