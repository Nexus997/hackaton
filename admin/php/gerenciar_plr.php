<?php
// Conexão com o banco de dados
$servername = "localhost:3308"; // Nome do servidor
$username = "root"; // Nome de usuário do banco
$password = "etec2024"; // Senha do banco (deixe em branco se não houver senha)
$dbname = "administracao"; // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscando todos os funcionários para o dropdown
$sql = "SELECT idFuncionario, nome FROM funcionario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $funcionarios = [];
    while ($row = $result->fetch_assoc()) {
        $funcionarios[] = $row;
    }
} else {
    die("Nenhum funcionário encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular PLR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        select, input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<h2>Calcular PLR</h2>

<form action="" method="post">
    <label for="funcionario">Selecione o funcionário:</label>
    <select id="funcionario" name="funcionario" required>
        <option value="">Selecione</option>
        <?php
        foreach ($funcionarios as $funcionario) {
            echo '<option value="' . $funcionario['idFuncionario'] . '">' . $funcionario['nome'] . '</option>';
        }
        ?>
    </select>

    <label for="dataFim">Data referente ao dia do cálculo:</label>
    <input type="date" id="dataFim" name="dataFim" required>

    <input type="submit" value="Calcular PLR">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturando o ID do funcionário selecionado
    $idFuncionario = $_POST['funcionario'];

    // Capturando a data de referência
    $dataFim = $_POST['dataFim'];

    // Buscando os dados do funcionário selecionado
    $sql = "SELECT nome, salario, dataAdmissao FROM funcionario WHERE idFuncionario = $idFuncionario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $funcionario = $result->fetch_assoc();
        $salarioAtual = (float)$funcionario['salario'];
        $dataInicio = $funcionario['dataAdmissao'];
        $nomeFuncionario = $funcionario['nome'];
    } else {
        die("Funcionário não encontrado.");
    }

    // Função para calcular a diferença em meses entre duas datas
    function calcularDiferencaMeses($dataInicio, $dataFim) {
        $data1 = new DateTime($dataInicio);
        $data2 = new DateTime($dataFim);

        // Calculando a diferença entre as datas
        $intervalo = $data1->diff($data2);
        
        // Calculando a diferença total em meses
        $totalMeses = ($intervalo->y * 12) + $intervalo->m;

        return $totalMeses;
    }

    // Função para calcular o PLR de acordo com os meses
    function calcularPlr($salario, $meses) {
        if ($meses < 12) {
            // Se os meses forem menos que 12, divide por 12 e multiplica por 65% do salário original
            $benefício = ($meses / 12) * ($salario * 0.65);
            return $salario + $benefício;
        } else {
            // Se for 12 meses ou mais, multiplica o salário por 1.65
            return $salario * 1.65;
        }
    }

    // Calcula a diferença em meses
    $meses = calcularDiferencaMeses($dataInicio, $dataFim);

    // Calcula o PLR com base na quantidade de meses
    $salarioAjustado = calcularPlr($salarioAtual, $meses);

    // Exibindo os resultados
    echo "<div class='result'>";
    echo "<h3>Resultado para $nomeFuncionario:</h3>";
    echo "Meses de registro: " . $meses . "<br>";
    echo "Salário total: R$ " . number_format($salarioAtual, 2, ',', '.') . "<br>";
    echo "Benefício: R$ " . number_format($salarioAjustado, 2, ',', '.');
    echo "</div>";
}

// Fechando a conexão
$conn->close();
?>

</body>
</html>