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
    $idFuncionario = isset($_POST['idFuncionario']) ? $_POST['idFuncionario'] : null;
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $dataNasc = $_POST['dataNasc'];
    $dataAdmissao = $_POST['dataAdmissao'];
    $idDepartamento = $_POST['idDepartamento'];
    $contato = $_POST['contato'];
    $salario = $_POST['salario'];

    // Calcular a idade
    $dataNascObj = new DateTime($dataNasc);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNascObj)->y;

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
