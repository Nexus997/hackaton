<?php
// Conexão com o banco de dados
$host = 'localhost:3308'; // ou o seu host
$db = 'administracao';
$user = 'root'; // seu usuário
$pass = 'etec2024'; // sua senha

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processar o formulário quando submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $idade = $_POST['idade'];
    $dataNasc = $_POST['dataNasc'];
    $dataAdmissao = $_POST['dataAdmissao'];
    $idDepartamento = $_POST['idDepartamento'];
    $contato = $_POST['contato'];
    $salario = $_POST['salario'];

    // Inserir no banco de dados
    $sql = "INSERT INTO funcionario (nome, documento, idade, dataNasc, dataAdmissao, idDepartamento, contato, salario) 
            VALUES ('$nome', '$documento', $idade, '$dataNasc', '$dataAdmissao', $idDepartamento, '$contato', '$salario')";

    if ($conn->query($sql) === TRUE) {
        echo "Funcionário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
</head>
<body>
    <h1>Cadastro de Funcionário</h1>
    <form method="POST" action="">
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
        <input type="number" id="idDepartamento" name="idDepartamento" required><br><br>

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato" required><br><br>

        <label for="salario">Salário:</label>
        <input type="text" id="salario" name="salario" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
