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
   

    // Inserir no banco de dados
    $sql = "INSERT INTO departamento (nomeDepartamento) 
            VALUES ('$nome')";

    if ($conn->query($sql) === TRUE) {
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