<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Ação</title>
</head>
<body>

<a href="listaPaciente.php">Ir à lista de pacientes</a>

<?php
// Conectar ao banco de dados
require_once('conn.php'); // Certifique-se de que o arquivo conn.php contém as credenciais do seu banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nomeAcao = isset($_POST['nomeAcao']) ? $_POST['nomeAcao'] : '';
    $dataAcao = isset($_POST['dataAcao']) ? $_POST['dataAcao'] : '';
    $localAcao = isset($_POST['local']) ? $_POST['local'] : '';
    $tipoAcao = isset($_POST['tipoAcao']) ? $_POST['tipoAcao'] : '';

    // Verifica se os campos estão preenchidos
    if (!empty($nomeAcao) && !empty($dataAcao) && !empty($localAcao) && !empty($tipoAcao)) {
        // Prepara a consulta SQL
        $sql = "INSERT INTO acoes (nomeAcao, dataAcao, tipoAcao, localAcao) VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $nomeAcao, $dataAcao, $tipoAcao, $localAcao);
        
        // Executa a consulta
        if (mysqli_stmt_execute($stmt)) {
            // Obtem o id da ação criada
            $idAcao = mysqli_insert_id($conn);

            // Fecha a declaração
            mysqli_stmt_close($stmt);

            // Redireciona para listaPaciente.php com o idAcao
            echo "<form id='redirectForm' action='listaPaciente.php' method='post'>
                    <input type='hidden' name='idAcao' value='" . htmlspecialchars($idAcao) . "'>
                  </form>";
            echo "<script>document.getElementById('redirectForm').submit();</script>";
            exit; // Para garantir que o script não continue executando
        } else {
            // Redireciona para listaAcao.php em caso de erro
            header("Location: listaAcao.php");
            exit;
        }
    } else {
        // Redireciona para listaAcao.php em caso de campos obrigatórios não preenchidos
        header("Location: listaAcao.php");
        exit;
    }
}

// Fecha a conexão
mysqli_close($conn);
?>
</body>
</html>
