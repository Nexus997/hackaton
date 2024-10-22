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
    $dataNasc = $_POST['dataNasc'];
    $dataAdmissao = $_POST['dataAdmissao'];
    $idDepartamento = $_POST['idDepartamento'];
    $contato = $_POST['contato'];
    $salario = $_POST['salario'];

    // Validação básica para verificar se os campos não estão vazios
    if (empty($nome) || empty($documento) || empty($dataNasc) || empty($dataAdmissao) || empty($idDepartamento) || empty($contato) || empty($salario)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Calcular a idade
    $dataNascObj = new DateTime($dataNasc);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNascObj)->y;

    // Inserir no banco de dados
    $sql = "INSERT INTO funcionario (nome, documento, idade, dataNasc, dataAdmissao, idDepartamento, contato, salario) 
            VALUES ('$nome', '$documento', $idade, '$dataNasc', '$dataAdmissao', $idDepartamento, '$contato', '$salario')";

    if ($conn->query($sql) === TRUE) {
        echo "Funcionário cadastrado com sucesso!";
        echo "<form id='redirectForm' action='listaFuncionario.php' method='post'>
            <input type='hidden' name='idDepartamento' value='" . htmlspecialchars($idDepartamento) . "'>
        </form>";
        echo "<script>document.getElementById('redirectForm').submit();</script>";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
