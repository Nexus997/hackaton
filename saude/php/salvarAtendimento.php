<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salvar Atendimento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>

<?php
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $idPaciente = $_POST['idPaciente'];
    $nomePaciente = $_POST['nomePaciente'];
    $dataNasc = $_POST['dataNasc'];
    $bairro = $_POST['bairro'];
    $generoPaciente = $_POST['generoPaciente'];
    $statusTrabalhista = $_POST['statusTrabalhista'];
    $contatoPaciente = $_POST['contatoPaciente'];
    $documentoPaciente = $_POST['documentoPaciente'];
    $observacoesPaciente = $_POST['observacoesPaciente'];
    $alturaPaciente = $_POST['alturaPaciente'];
    $pesoPaciente = $_POST['pesoPaciente'];
    $tipoSanguineo = $_POST['tipoSanguineo'];
    $pressao = $_POST['pressao'];
    $dataAtendimento = $_POST['dataAtendimento'];
    $localAtendimento = $_POST['localAtendimento'];
    $responsavelAtendimento = $_POST['responsavelAtendimento'];
    $observacaoAtendente = $_POST['observacaoAtendente'];

    // Atualiza os dados do paciente
    $sql = "UPDATE paciente 
        SET nomePaciente = ?, dataNasc = ?, bairro = ?, generoPaciente = ?, statusTrabalho = ?, 
            contatoPaciente = ?, documentoPaciente = ?, observacaoPaciente = ?, alturaPaciente = ?, 
            pesoPaciente = ?, tipoSanguineo = ?, pressao = ?, dataAtendimento = ?, 
            localAtendimento = ?, responsavelAtendimento = ?, observacaoAtendente = ?
        WHERE idPaciente = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssssssssi', $nomePaciente, $dataNasc, $bairro, 
        $generoPaciente, $statusTrabalhista, $contatoPaciente, $documentoPaciente, 
        $observacoesPaciente, $alturaPaciente, $pesoPaciente, $tipoSanguineo, 
        $pressao, $dataAtendimento, $localAtendimento, $responsavelAtendimento, 
        $observacaoAtendente, $idPaciente);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<p>Atendimento salvo com sucesso!</p>";
    } else {
        echo "<p>Erro ao salvar o atendimento: " . mysqli_error($conn) . "</p>";
    }

    // Fecha a consulta
    mysqli_stmt_close($stmt);
} else {
    echo "<p>Nenhum dado foi enviado.</p>";
}

// Fecha a conexão
mysqli_close($conn);
?>

<a href="listaPaciente.php">Voltar à lista de pacientes</a>

</body>
</html>
