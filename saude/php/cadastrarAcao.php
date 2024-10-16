<html>
    
<a href="listaPaciente.php">Ir à lista de pacientes</a>
</html>
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
            echo "Ação cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a ação: " . mysqli_error($conn);
        }

        // Fecha a declaração
        mysqli_stmt_close($stmt);
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}

// Fecha a conexão
mysqli_close($conn);
?>
