<?php

require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica os parâmetros de pesquisa
$nomeBusca = isset($_POST['nomeBusca']) ? $_POST['nomeBusca'] : '';
$generoBusca = isset($_POST['generoBusca']) ? $_POST['generoBusca'] : '';
$dataNascBusca = isset($_POST['dataNascBusca']) ? $_POST['dataNascBusca'] : '';
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

// Filtro por data de nascimento
if ($dataNascBusca) {
    $sql .= " AND dataNasc = ?";
    $params[] = $dataNascBusca;
    $types .= 's';
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
        switch ($row['statusTrabalho']) {
            case 'empregado':
                $statusTrabalhista = 'Empregado';
                break;
            case 'autonomo':
                $statusTrabalhista = 'Autônomo';
                break;
            case 'desempregado':
                $statusTrabalhista = 'Desempregado';
                break;
            case 'estagiario':
                $statusTrabalhista = 'Estagiário';
                break;
            case 'aposentado':
                $statusTrabalhista = 'Aposentado';
                break;
            case 'pensionista':
                $statusTrabalhista = 'Pensionista';
                break;
            case 'licenca':
                $statusTrabalhista = 'Licença';
                break;
            default:
                $statusTrabalhista = 'Não especificado';
                break;
        }

        echo "<tr>
                <td>{$row['nomePaciente']}</td>
                <td>{$row['dataNasc']}</td>
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
