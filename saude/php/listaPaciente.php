<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

$idAcao = isset($_POST['idAcao']) ? $_POST['idAcao'] : null;

// Verifica se idAcao foi fornecido
if ($idAcao === null) {
    header("Location: listaAcao.php");
    exit();
}

// Função para verificar se o valor está vazio e, se sim, retornar 'Indefinido'
function definirIndefinido($valor) {
    return empty($valor) ? 'Indefinido' : $valor;
}

// Função para censurar os dados
function censurarDados($valor) {
    // Se o valor estiver vazio ou nulo, não faz nada
    if (empty($valor)) {
        return $valor;
    }

    // Se a string tiver 4 ou menos caracteres, censura apenas os primeiros
    if (strlen($valor) <= 4) {
        return str_repeat('*', max(strlen($valor) - 1, 0)) . substr($valor, -1);
    }

    // Caso contrário, censura todos os caracteres, exceto os 3 primeiros e o último
    return substr($valor, 0, 3) . str_repeat('*', max(strlen($valor) - 4, 0)) . substr($valor, -1);
}


// Consulta para buscar o nome da ação
$sqlAcao = "SELECT nomeAcao FROM acoes WHERE idAcao = ?";
$stmtAcao = mysqli_prepare($conn, $sqlAcao);
mysqli_stmt_bind_param($stmtAcao, 'i', $idAcao);
mysqli_stmt_execute($stmtAcao);
$resultAcao = mysqli_stmt_get_result($stmtAcao);
$acao = mysqli_fetch_assoc($resultAcao);

// Verifica se a ação existe
if (!$acao) {
    header("Location: listaAcao.php");
    exit();
}

$nomeAcao = $acao['nomeAcao'];

// Consulta para buscar pacientes
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
    <link rel="icon" href="../img/logo atend+.png" type="image/x-icon">
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
<h1><?php echo htmlspecialchars($nomeAcao); ?></h1> <!-- Novo h1 para o nome da ação -->

<div class="filtros-container">
    <!-- Filtro por nome -->
    <input type="text" id="nomeBusca" placeholder="Buscar por nome..." onkeyup="buscarPacientes()">

    <!-- Filtro por gênero -->
    <select id="generoBusca" onchange="buscarPacientes()">
        <option value="" disabled selected hidden>Filtrar por gênero</option>
        <option value="" >Sem filtro</option>
        <option value="M">Masculino</option>
        <option value="F">Feminino</option>
    </select>

    <!-- Filtro por faixa etária -->
    <select id="idadeBusca" onchange="buscarPacientes()">
        <option value="" disabled selected hidden>Filtrar por faixa etária</option>
        <option value="" >Sem filtro</option>
        <option value="menor18">Menor de 18</option>
        <option value="18-25">18 - 25</option>
        <option value="26-40">26 - 40</option>
        <option value="41-65">41 - 65</option>
        <option value="acima65">Acima de 65</option>
    </select>

    <!-- Filtro por status trabalhista -->
    <select id="statusBusca" onchange="buscarPacientes()">
        <option value="" disabled selected hidden>Filtrar por status trabalhista</option>
        <option value="" >Sem filtro</option>
        <option value="empregado">Empregado</option>
        <option value="autonomo">Autônomo</option>
        <option value="desempregado">Desempregado</option>
        <option value="estagiario">Estudante</option>
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
                <th>Contato <button id='btn-contato' onclick='toggleCensuraPorColuna(\"contato\")'>Mostrar</button></th>
                <th>Documento <button id='btn-documento' onclick='toggleCensuraPorColuna(\"documento\")'>Mostrar</button></th>
                <th>Observações</th>
                <th>Atendimento</th>
            </tr>";

    // Loop para mostrar os dados
    while ($row = mysqli_fetch_assoc($result)) {
        // Verifica e formata o gênero conforme as novas regras
        if ($row['generoPaciente'] === 'M') {
            $genero = 'Masculino';
        } elseif ($row['generoPaciente'] === 'F') {
            $genero = 'Feminino';
        } else {
            $genero = 'Não especificado';
        }

        // Verifica e define o status trabalhista
        $statusTrabalhista = empty($row['statusTrabalho']) ? 'Indefinido' : $row['statusTrabalho'];

        // Censura os campos de contato e documento se não forem 'Indefinido'
        $contatoPaciente = empty($row['contatoPaciente']) ? 'Indefinido' : $row['contatoPaciente'];
        $documentoPaciente = empty($row['documentoPaciente']) ? 'Indefinido' : $row['documentoPaciente'];
        $contatoCensurado = censurarDados($contatoPaciente);
        $documentoCensurado = censurarDados($documentoPaciente);

        // Verifica e define a data de nascimento
        $dataPaciente = $row['dataNasc'] ? date('d/m/Y', strtotime($row['dataNasc'])) : 'Indefinido';

        // A idade agora é obtida diretamente do banco e se for null, será "Indefinido"
        $idade = !empty($row['idade']) ? $row['idade'] : 'Indefinido';

        // Verifica e define o bairro
        $bairro = empty($row['bairro']) ? 'Indefinido' : $row['bairro'];

        // Verifica e define as observações
        $observacoesPaciente = empty($row['observacaoPaciente']) ? 'Indefinido' : $row['observacaoPaciente'];

        // Exibe a linha da tabela
        echo "<tr>
                <td>{$row['nomePaciente']}</td>
                <td>{$dataPaciente}</td>
                <td>{$idade}</td>
                <td>{$bairro}</td>
                <td>{$genero}</td>
                <td>{$statusTrabalhista}</td>
                <td class='contato-col' data-original='{$contatoPaciente}'>{$contatoCensurado}</td>
                <td class='documento-col' data-original='{$documentoPaciente}'>{$documentoCensurado}</td>
                <td>{$observacoesPaciente}</td>
                <td>
                    <form action='atendimento.php' method='post'>
                         <input type='hidden' name='idAcao' value='{$row['idAcao']}'>
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
        var idadeBusca = $("#idadeBusca").val();
        var statusBusca = $("#statusBusca").val();
        var idAcao = "<?php echo $idAcao; ?>"; 

        $.ajax({
            url: 'buscar_pacientes.php',
            type: 'POST',
            data: { 
                nomeBusca: nomeBusca, 
                generoBusca: generoBusca, 
                idadeBusca: idadeBusca, 
                statusBusca: statusBusca,
                idAcao: idAcao 
            },
            success: function(response) {
                $("#resultados").html(response);
            }
        });
    }

    function toggleCensuraPorColuna(coluna) {
    var cells = document.querySelectorAll(`.${coluna}-col`); // Seleciona todas as células da coluna
    var button = document.querySelector(`#btn-${coluna}`); // Seleciona o botão da coluna

    cells.forEach(function(cell) {
        var originalValue = cell.dataset.original; // Pega o valor original (não censurado)
        var currentText = cell.innerText.trim(); // Pega o texto visível atualmente

        // Se o valor atual estiver censurado, exibe o valor original
        if (currentText.includes('*')) {
            cell.innerHTML = originalValue;
            
        } else {
            // Caso contrário, censura o valor
            var censoredValue = censurarDados(originalValue);
            cell.innerHTML = censoredValue;
        }
    });

    // Alterna o texto do botão entre "Mostrar" e "Ocultar"
    if (button.innerText === "Mostrar") {
        button.innerText = "Ocultar";
    } else {
        button.innerText = "Mostrar";
    }
}

    // Função para censurar os dados
    function censurarDados(valor) {
        if (valor === 'Indefinido') {
            return valor; // Não censura 'Indefinido'
        }
        if (valor.length <= 4) {
            return str_repeat('*', valor.length - 1) + valor.slice(-1);
        }
        return valor.slice(0, 3) + str_repeat('*', valor.length - 4) + valor.slice(-1);
    }

    // Função auxiliar para repetir o caractere
    function str_repeat(char, times) {
        return new Array(times + 1).join(char);
    }
</script>

</body>
</html>
