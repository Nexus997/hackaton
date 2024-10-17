

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
</head>
<body>
    <h1>Cadastro de Funcionário</h1>
    <form method="POST" action="cadastrarFuncionario.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="documento">Documento:</label>
        <input type="text" id="documento" name="documento" required><br><br>

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required><br><br>

        <label for="dataNasc">Data de Nascimento:</label>
        <input type="date" id="dataNasc" name="dataNasc" required><br><br>

        <label for="dataAdmissao">Data de Admissão:</label>
        <input type="date" id="dataAdmissao" name="dataAdmissao" required><br><br>

        <label for="idDepartamento">ID do Departamento:</label>
        <select id="idDepartamento" name="idDepartamento" required>
            <option value="" disabled selected>Selecione um departamento</option>
            <?php
            // Conexão com o banco de dados
            require_once('conn.php');
            $conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

            // Consulta para pegar os departamentos
            $sql = "SELECT idDepartamento, nomeDepartamento FROM departamento";
            $result = mysqli_query($conn, $sql);

            // Verifica se há departamentos e cria as opções
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['idDepartamento']}'>{$row['nomeDepartamento']}</option>";
                }
            } else {
                echo "<option value='' disabled>Nenhum departamento encontrado</option>";
            }

            mysqli_close($conn);
            ?>
        </select><br><br>

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato" required><br><br>

        <label for="salario">Salário:</label>
        <input type="text" id="salario" name="salario" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
