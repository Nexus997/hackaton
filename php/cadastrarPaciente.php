<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    
<?php 
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    
    header("Location: erro.php");
    exit;
}

require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nomePaciente = $_POST['nomePaciente'];
    $dataNasc = $_POST['dataNasc'];
    $bairro = $_POST['bairro'];
    $generoPaciente = $_POST['generoPaciente'];
    $statusTrabalhista = $_POST['statusTrabalhista'];
    $contatoPaciente = $_POST['contatoPaciente'];
    $documentoPaciente = $_POST['documentoPaciente'];
    $observacoesPaciente = $_POST['observacoesPaciente'];
    $idAcao = $_POST['idAcao'];

    function calcularIdade($dataNascimento) {
        $dataNascimento = new DateTime($dataNascimento);
        $hoje = new DateTime();
        return $hoje->diff($dataNascimento)->y;
    }

    $idade = calcularIdade($dataNasc);

    $sql = "INSERT INTO paciente (
        nomePaciente, 
        dataNasc, 
        idade, 
        bairro, 
        generoPaciente, 
        statusTrabalho, 
        contatoPaciente, 
        documentoPaciente, 
        observacaoPaciente,
        idAcao
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = mysqli_prepare($conn, $sql);
    
    // Adicione a idade ao binding dos parâmetros
    mysqli_stmt_bind_param($stmt, 'sssssssssi', $nomePaciente, $dataNasc, $idade, $bairro, $generoPaciente, $statusTrabalhista, $contatoPaciente, $documentoPaciente, $observacoesPaciente, $idAcao);

    if (mysqli_stmt_execute($stmt)) {
        echo "Paciente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar paciente: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

$conn->close();
?>

<a href="listaPaciente.php">Ir à lista de pacientes</a>
</body>
</html>
