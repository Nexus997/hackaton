<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Faltas</title>
</head>
<body>
    <h1>Cadastro de Faltas</h1>
    <form method="POST" action="cadastrarFalta.php">
        <label for="idFuncionario">Funcionário:</label>
        <select id="idFuncionario" name="idFuncionario" required>
            <option value="" disabled selected>Selecione um funcionário</option>
            <?php
            require_once('conn.php');
            $conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

            // Consulta para pegar todos os funcionários e seus departamentos
            $sql = "SELECT f.idFuncionario, f.nome, d.nomeDepartamento FROM funcionario f 
                    LEFT JOIN departamento d ON f.idDepartamento = d.idDepartamento";
            $result = mysqli_query($conn, $sql);

            // Verifica se há funcionários e cria as opções
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['idFuncionario']}'>{$row['nome']} - {$row['nomeDepartamento']}</option>";
                }
            } else {
                echo "<option value='' disabled>Nenhum funcionário encontrado</option>";
            }

            mysqli_close($conn);
            ?>
        </select><br><br>

        <label for="dataFalta">Data da Falta:</label>
        <input type="date" id="dataFalta" name="dataFalta" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="motivo">Motivo:</label>
        <textarea id="motivo" name="motivo" required></textarea><br><br>

        <input type="submit" value="Registrar Falta">
    </form>
</body>
</html>
