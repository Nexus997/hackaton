<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
    /* Estilo para a tabela */
    table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px 0;
    }
    
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        vertical-align: top; /* Alinha o texto na parte superior da célula */
    }

    th {
        background-color: #f2f2f2;
    }

    /* Estilo para o formulário */
    form {
        margin: 20px 0;
        border: 1px solid #ddd;
        padding: 15px;
        
        border-radius: 5px;
        width: 800px; /* Ajuste a largura conforme necessário */
    }

    label {
        display: block; /* Faz com que cada label fique em sua linha */
        margin: 10px 0 5px; /* Margem para separar os campos */
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        width: 250px; /* Faz os campos ocuparem toda a largura do formulário */
        padding: 8px;
        margin-bottom: 10px; /* Espaçamento entre os campos */
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    textarea {
        height: 100px; /* Altura fixa para o textarea, ajuste conforme necessário */
    }

    button {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        background-color: #007BFF; /* Cor do botão */
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3; /* Cor ao passar o mouse */
    }
</style>


<?php
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica se o ID do paciente foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idPaciente'])) {
    $idPaciente = $_POST['idPaciente'];

    // Consulta para obter os dados do paciente
    $sql = "SELECT * FROM paciente WHERE idPaciente = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idPaciente);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se o paciente foi encontrado
    if ($row = mysqli_fetch_assoc($result)) {
        // Exibe o formulário com os dados do paciente
        echo "<form action='salvarAtendimento.php' method='post'>
                <label for='nomePaciente'>Nome:</label>
                <input type='text' name='nomePaciente' id='nomePaciente' value='{$row['nomePaciente']}' required>

                <label for='dataNasc'>Data de Nascimento:</label>
                <input type='date' name='dataNasc' id='dataNasc' value='{$row['dataNasc']}' required>

                <label for='bairro'>Bairro:</label>
                <input type='text' name='bairro' id='bairro' value='{$row['bairro']}' required>

                <label for='generoPaciente'>Gênero:</label>
                <select name='generoPaciente' id='generoPaciente' required>
                    <option value='M' " . ($row['generoPaciente'] == 'M' ? 'selected' : '') . ">Masculino</option>
                    <option value='F' " . ($row['generoPaciente'] == 'F' ? 'selected' : '') . ">Feminino</option>
                </select>

                <label for='statusTrabalhista'>Situação Trabalhista:</label>
                <select name='statusTrabalhista' id='statusTrabalhista' required>
                    <option value='empregado' " . ($row['statusTrabalho'] == 'empregado' ? 'selected' : '') . ">Empregado</option>
                    <option value='autonomo' " . ($row['statusTrabalho'] == 'autonomo' ? 'selected' : '') . ">Autônomo</option>
                    <option value='desempregado' " . ($row['statusTrabalho'] == 'desempregado' ? 'selected' : '') . ">Desempregado</option>
                    <option value='estagiario' " . ($row['statusTrabalho'] == 'estagiario' ? 'selected' : '') . ">Estagiário</option>
                    <option value='aposentado' " . ($row['statusTrabalho'] == 'aposentado' ? 'selected' : '') . ">Aposentado</option>
                    <option value='pensionista' " . ($row['statusTrabalho'] == 'pensionista' ? 'selected' : '') . ">Pensionista</option>
                    <option value='licenca' " . ($row['statusTrabalho'] == 'licenca' ? 'selected' : '') . ">Licença</option>
                </select>

                <label for='contatoPaciente'>Contato:</label>
                <input type='text' name='contatoPaciente' id='contatoPaciente' value='{$row['contatoPaciente']}' required>

                <label for='documentoPaciente'>Documento:</label>
                <input type='text' name='documentoPaciente' id='documentoPaciente' value='{$row['documentoPaciente']}' required>

                <label for='observacoesPaciente'>Observações:</label>
                <textarea name='observacoesPaciente' id='observacoesPaciente'>{$row['observacaoPaciente']}</textarea>

                <label for='alturaPaciente'>Altura:</label>
                <input type='text' name='alturaPaciente' id='alturaPaciente' value='{$row['alturaPaciente']}'>

                <label for='pesoPaciente'>Peso:</label>
                <input type='text' name='pesoPaciente' id='pesoPaciente' value='{$row['pesoPaciente']}'>

                <label for='tipoSanguineo'>Tipo Sanguíneo:</label>
                <input type='text' name='tipoSanguineo' id='tipoSanguineo' value='{$row['tipoSanguineo']}'>

                <label for='pressao'>Pressão:</label>
                <input type='text' name='pressao' id='pressao' value='{$row['pressao']}'>

                <label for='dataAtendimento'>Data do Atendimento:</label>
                <input type='date' name='dataAtendimento' id='dataAtendimento' value='{$row['dataAtendimento']}'>

                <label for='localAtendimento'>Local do Atendimento:</label>
                <input type='text' name='localAtendimento' id='localAtendimento' value='{$row['localAtendimento']}'>

                <label for='responsavelAtendimento'>Responsável pelo Atendimento:</label>
                <input type='text' name='responsavelAtendimento' id='responsavelAtendimento' value='{$row['responsavelAtendimento']}'>

                <label for='observacaoAtendente'>Observação do Atendente:</label>
                <textarea name='observacaoAtendente' id='observacaoAtendente'>{$row['observacaoAtendente']}</textarea>
                <input type='hidden' value='$idPaciente' name='idPaciente'>
                <button type='submit'>Salvar Atendimento</button>
              </form>";
    } else {
        echo "Paciente não encontrado.";
    }

    // Fechar a consulta
    mysqli_stmt_close($stmt);
} else {
    echo "ID do paciente não recebido.";
}

// Fechar a conexão
mysqli_close($conn);
?>

</body>
</html>
