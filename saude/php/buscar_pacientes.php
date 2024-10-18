<?php

require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

function censurarDados($valor) {
    if (strlen($valor) <= 4) {
        return str_repeat('*', strlen($valor) - 1) . substr($valor, -1);
    }
    return substr($valor, 0, 3) . str_repeat('*', strlen($valor) - 4) . substr($valor, -1);
}
// Verifica os parâmetros de pesquisa
$nomeBusca = isset($_POST['nomeBusca']) ? $_POST['nomeBusca'] : '';
$generoBusca = isset($_POST['generoBusca']) ? $_POST['generoBusca'] : '';
$idadeBusca = isset($_POST['idadeBusca']) ? $_POST['idadeBusca'] : '';
$statusBusca = isset($_POST['statusBusca']) ? $_POST['statusBusca'] : '';
$idAcao = isset($_POST['idAcao']) ? $_POST['idAcao'] : null; // Captura o idAcao

// Monta a consulta SQL com filtros
$sql = "SELECT * FROM paciente WHERE idAcao = ?"; // Filtro por idAcao
$params = [$idAcao];
$types = 'i'; // 'i' para inteiro, já que idAcao é um número

// Filtro por nome
if ($nomeBusca) {
    $sql .= " AND nomePaciente LIKE ?";
    $params[] = "%$nomeBusca%";
    $types .= 's';
}

// Filtro por gênero
if ($generoBusca) {
    $sql .= " AND generoPaciente = ?";
    $params[] = $generoBusca;
    $types .= 's';
}

// Filtro por faixa etária
if ($idadeBusca) {
    if ($idadeBusca === 'menor18') {
        $sql .= " AND idade < 18";
    } elseif ($idadeBusca === '18-25') {
        $sql .= " AND idade BETWEEN 18 AND 25";
    } elseif ($idadeBusca === '26-40') {
        $sql .= " AND idade BETWEEN 26 AND 40";
    } elseif ($idadeBusca === '41-65') {
        $sql .= " AND idade BETWEEN 41 AND 65";
    } elseif ($idadeBusca === 'acima65') {
        $sql .= " AND idade > 65";
    }
}

// Filtro por status trabalhista
if ($statusBusca) {
    $sql .= " AND statusTrabalho = ?";
    $params[] = $statusBusca;
    $types .= 's';
}

// Prepara a consulta
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Idade</th>
                <th>Bairro</th>
                <th>Gênero</th>
                <th>Status Trabalhista</th>
                <th>Contato</th>
                <th>Documento</th>
                <th>Observações</th>
                <th>Atendimento</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $genero = $row['generoPaciente'] === 'M' ? 'Masculino' : 'Feminino';
        $statusTrabalhista = !empty($row['statusTrabalho']) ? $row['statusTrabalho'] : 'Não especificado';
        $contatoCensurado = censurarDados($row['contatoPaciente']);
        $documentoCensurado = censurarDados($row['documentoPaciente']);
        $dataPaciente = date('d/m/Y', strtotime($row['dataNasc']));
        echo "<tr>
                <td>{$row['nomePaciente']}</td>  
                <td>{$dataPaciente}</td>
                <td>{$row['idade']}</td>
                <td>{$row['bairro']}</td>
                <td>$genero</td>
                <td>$statusTrabalhista</td>
                <td>$contatoCensurado</td>
                    <td>$documentoCensurado</td>
                <td class='observacao'>{$row['observacaoPaciente']}</td> 
                <td>
                    <form action='atendimento.php' method='post'>
                        <input type='hidden' name='idPaciente' value='{$row['idPaciente']}'>
                        <button type='submit'>Atender</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum paciente encontrado.";
}

// Fechar a conexão
mysqli_close($conn);
?>
