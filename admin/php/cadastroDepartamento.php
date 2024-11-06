

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Departamento</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
<nav>
    <a href="listaDepartamento.php">Voltar</a>
</nav>

    <h1>Cadastro de Departamento</h1>
    <form method="POST" action="cadastrarDepartamento.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <button type="submit">Cadastrar Departamento</button>
    </form>
</body>
</html>
