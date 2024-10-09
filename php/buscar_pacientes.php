<?php

require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica os parâmetros de pesquisa
$nomeBusca = isset($_POST['nomeBusca']) ? $_POST['nomeBusca'] : '';
$generoBusca = isset($_POST['generoBusca']) ? $_POST['generoBusca'] : '';
$idadeBusca = isset($_POST['idadeBusca']) ? $_POST['idadeBusca'] : '';
$statusBusca = isset($_POST['statusBusca']) ? $_POST['statusBusca'] : '';

// Monta a consulta SQL com filtros
$sql = "SELECT * FROM paciente WHERE 1=1";
$params = [];
$types = '';

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

// Prepara a consulta apenas se houver filtros
if (count($params) > 0) {
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($conn, $sql);  // Se não houver filtros, executa normalmente
}

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
        // Verifica e formata o gênero
        $genero = $row['generoPaciente'] === 'M' ? 'Masculino' : 'Feminino';

        // Formata o status trabalhista
        $statusTrabalhista = !empty($row['statusTrabalho']) ? $row['statusTrabalho'] : 'Não especifcado';


        echo "<tr>
                <td>{$row['nomePaciente']}</td>  
                <td>{$row['dataNasc']}</td>
                <td>{$row['idade']}</td>
                <td>{$row['bairro']}</td>
                <td>$genero</td>
                <td>$statusTrabalhista</td>
                <td>{$row['contatoPaciente']}</td>
                <td>{$row['documentoPaciente']}</td>
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
