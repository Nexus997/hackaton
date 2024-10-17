<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

$idAcao = isset($_POST['idAcao']) ? $_POST['idAcao'] : null;

// Função para censurar os dados
function censurarDados($valor) {
    if (strlen($valor) <= 4) {
        return str_repeat('*', strlen($valor) - 1) . substr($valor, -1);
    }
    return substr($valor, 0, 3) . str_repeat('*', strlen($valor) - 4) . substr($valor, -1);
}

$sql = "SELECT * FROM paciente WHERE idAcao = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $idAcao);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="css/lista_pacientes.css"> <!-- Link para o CSS externo -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<nav>
    <a href="listaAcao.php">Voltar</a>
</nav>

<style>
    td {
        max-width: 250px;  /* Largura máxima */
        overflow-wrap: break-word;  /* Quebra de palavras */
        white-space: normal;  /* Permite múltiplas linhas */
    }
</style>

<h1>Lista de Pacientes</h1>

<div class="filtros-container">
    <!-- Filtro por nome -->
    <input type="text" id="nomeBusca" placeholder="Buscar por nome..." onkeyup="buscarPacientes()">

    <!-- Filtro por gênero -->
    <select id="generoBusca" onchange="buscarPacientes()">
        <option value="">Filtrar por gênero</option>
        <option value="M">Masculino</option>
        <option value="F">Feminino</option>
    </select>

    <!-- Filtro por faixa etária -->
    <select id="idadeBusca" onchange="buscarPacientes()">
        <option value="" disabled selected hidden>Filtrar por faixa etária</option>
        <option value="menor18">Menor de 18</option>
        <option value="18-25">18 - 25</option>
        <option value="26-40">26 - 40</option>
        <option value="41-65">41 - 65</option>
        <option value="acima65">Acima de 65</option>
    </select>

    <!-- Filtro por status trabalhista -->
    <select id="statusBusca" onchange="buscarPacientes()">
        <option value="">Filtrar por status trabalhista</option>
        <option value="empregado">Empregado</option>
        <option value="autonomo">Autônomo</option>
        <option value="desempregado">Desempregado</option>
        <option value="estagiario">Estagiário</option>
        <option value="aposentado">Aposentado</option>
        <option value="pensionista">Pensionista</option>
        <option value="licenca">Licença</option>
    </select>
    <form id="cadastroPacienteForm" action="cadastroPaciente.php" method="post" style="display: inline;">
    <input type="hidden" name="idAcao" value="<?php echo $idAcao; ?>">
    <button type="submit">Cadastrar Paciente</button>
</form>
</div>

<div id="resultados">
    <?php
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
            $statusTrabalhista = !empty($row['statusTrabalho']) ? $row['statusTrabalho'] : 'Não especificado';

            // Censura os campos de contato e documento
            $contatoCensurado = censurarDados($row['contatoPaciente']);
            $documentoCensurado = censurarDados($row['documentoPaciente']);

            echo "<tr>
                    <td>{$row['nomePaciente']}</td>
                    <td>{$row['dataNasc']}</td>
                    <td>{$row['idade']}</td>
                    <td>{$row['bairro']}</td>
                    <td>$genero</td>
                    <td>$statusTrabalhista</td>
                    <td>$contatoCensurado</td>
                    <td>$documentoCensurado</td>
                    <td>{$row['observacaoPaciente']}</td>
                    
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

    mysqli_close($conn);
    ?>
</div>

<script>
    function buscarPacientes() {
        var nomeBusca = $("#nomeBusca").val();
        var generoBusca = $("#generoBusca").val();
        var idadeBusca = $("#idadeBusca").val(); // Nova variável para a faixa etária
        var statusBusca = $("#statusBusca").val();
        var idAcao = "<?php echo $idAcao; ?>"; 

        $.ajax({
            url: 'buscar_pacientes.php',
            type: 'POST',
            data: { 
                nomeBusca: nomeBusca, 
                generoBusca: generoBusca, 
                idadeBusca: idadeBusca, // Envio da faixa etária
                statusBusca: statusBusca,
                idAcao: idAcao // Envia o ID da ação para filtragem
            },
            success: function(response) {
                $("#resultados").html(response);
            }
        });
    }
</script>

</body>
</html>
