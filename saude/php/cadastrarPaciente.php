<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
</head>
<body>

<?php 
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: erro.php");
    exit;
}

require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica se o idAcao foi enviado
$idAcao = isset($_POST['idAcao']) ? $_POST['idAcao'] : null;

if ($idAcao === null) {
    header("Location: listaAcao.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nomePaciente = $_POST['nomePaciente'];
    $dataNasc = !empty($_POST['dataNasc']) ? $_POST['dataNasc'] : null;
    $bairro = $_POST['bairro'];
    $generoPaciente = !empty($_POST['generoPaciente']) ? $_POST['generoPaciente'] : null;
    $statusTrabalhista = !empty($_POST['statusTrabalhista']) ? $_POST['statusTrabalhista'] : null;
    $contatoPaciente = $_POST['contatoPaciente'];
    $documentoPaciente = $_POST['documentoPaciente'];
    $observacoesPaciente = $_POST['observacoesPaciente'];

    // Função para calcular a idade com base na data de nascimento
    function calcularIdade($dataNascimento) {
        if ($dataNascimento) {
            $dataNascimento = new DateTime($dataNascimento);
            $hoje = new DateTime();
            return $hoje->diff($dataNascimento)->y;
        }
        return null;  // Se a data não foi fornecida, idade será NULL
    }

    // Calcular a idade apenas se a data de nascimento for informada
    $idade = calcularIdade($dataNasc);

    // Inserção no banco de dados
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

    // Preparando a consulta
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssssi', $nomePaciente, $dataNasc, $idade, $bairro, $generoPaciente, $statusTrabalhista, $contatoPaciente, $documentoPaciente, $observacoesPaciente, $idAcao);

    // Executando a consulta
    if (mysqli_stmt_execute($stmt)) {
        // Redirecionando para listaPaciente.php com idAcao
        echo "<form id='redirectForm' action='listaPaciente.php' method='post' style='display: none;'>
                <input type='hidden' name='idAcao' value='" . htmlspecialchars($idAcao) . "'>
              </form>
              <script>
                document.getElementById('redirectForm').submit();
              </script>";
        exit; // Para garantir que nenhum código adicional seja executado
    } else {
        echo "Erro ao cadastrar paciente: " . mysqli_error($conn);
    }

    // Fechar a consulta
    mysqli_stmt_close($stmt);
}

// Fechar a conexão
$conn->close();
?>

</body>
</html>
