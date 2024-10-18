<!DOCTYPE html>
<html lang="pt-BR">
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
    $idPaciente = $_POST['idPaciente'] ?? null;
    $idAcao = $_POST['idAcao'] ?? null;
    $nomePaciente = $_POST['nomePaciente'] ?? '';
    $dataNasc = $_POST['dataNasc'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $generoPaciente = $_POST['generoPaciente'] ?? '';
    $statusTrabalhista = $_POST['statusTrabalhista'] ?? '';
    $contatoPaciente = $_POST['contatoPaciente'] ?? '';
    $documentoPaciente = $_POST['documentoPaciente'] ?? '';
    $observacoesPaciente = $_POST['observacoesPaciente'] ?? '';
    $alturaPaciente = $_POST['alturaPaciente'] ?? '';
    $pesoPaciente = $_POST['pesoPaciente'] ?? '';
    $tipoSanguineo = $_POST['tipoSanguineo'] ?? '';
    $pressao = $_POST['pressao'] ?? '';
    $dataAtendimento = $_POST['dataAtendimento'] ?? '';
    $localAtendimento = $_POST['localAtendimento'] ?? '';
    $responsavelAtendimento = $_POST['responsavelAtendimento'] ?? '';
    $observacaoAtendente = $_POST['observacaoAtendente'] ?? '';

    // Verifica se o idPaciente e idAcao são válidos
    if ($idPaciente === null || $idAcao === null) {
        header("Location: listaAcao.php");
        exit;
    }

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
        // Redireciona após o sucesso
        echo "<form id='redirectForm' action='listaPaciente.php' method='post' style='display: none;'>
                <input type='hidden' name='idAcao' value='" . htmlspecialchars($idAcao) . "'>
              </form>
              <script>
                document.getElementById('redirectForm').submit();
              </script>";
    } else {
        // Redireciona para listaAcao.php em caso de erro
        header("Location: listaAcao.php");
        exit;
    }

    // Fecha a consulta
    mysqli_stmt_close($stmt);
} else {
    // Redireciona para listaAcao.php se nenhum dado foi enviado
    header("Location: listaAcao.php");
    exit;
}

// Fecha a conexão
mysqli_close($conn);
?>

<a href="listaPaciente.php">Voltar à lista de pacientes</a>

</body>
</html>
