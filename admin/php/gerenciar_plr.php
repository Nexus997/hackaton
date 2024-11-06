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

// Verifica se o ID do funcionário foi passado por POST
$idFuncionario = isset($_POST['idFuncionario']) ? intval($_POST['idFuncionario']) : 0;
$idDepartamento = isset($_POST['idDepartamento']) ? intval($_POST['idDepartamento']) : 0;

// Buscando os dados do funcionário
$sql = "SELECT f.nome, f.salario, f.dataAdmissao, d.nomeDepartamento FROM funcionario f 
        JOIN departamento d ON f.idDepartamento = d.idDepartamento 
        WHERE f.idFuncionario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idFuncionario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $funcionario = $result->fetch_assoc();
    $nomeFuncionario = $funcionario['nome'];
    $salarioAtual = (float)$funcionario['salario'];
    $dataInicio = $funcionario['dataAdmissao'];
    $nomeDepartamento = $funcionario['nomeDepartamento'];
} else {
    die("Funcionário não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular PLR</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    
</head>
<body>

<nav class="voltar">
    <form action="listaFuncionario.php" method="post" style="display: inline;">
        <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <button class="voltarBtn" type="submit">Voltar</button>
    </form>
</nav>

<h2>Calcular PLR</h2>

<form action="" method="post">
    <label for="funcionario">Funcionário:</label>
    <input type="text" id="funcionario" name="funcionario" value="<?php echo htmlspecialchars($nomeFuncionario . ' - ' . $nomeDepartamento); ?>" readonly>

    <label for="dataFim">Data referente ao dia do cálculo:</label>
    <input type="date" id="dataFim" name="dataFim" required>

    <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario; ?>">
    <input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento; ?>">
    <button type="submit">Calcular PLR</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dataFim'])) {
    // Capturando a data de referência
    $dataFim = $_POST['dataFim'];

    // Função para calcular a diferença em meses entre duas datas
    function calcularDiferencaMeses($dataInicio, $dataFim) {
        $data1 = new DateTime($dataInicio);
        $data2 = new DateTime($dataFim);
        $intervalo = $data1->diff($data2);
        return ($intervalo->y * 12) + $intervalo->m;
    }

    // Função para calcular o PLR de acordo com os meses
    function calcularPlr($salario, $meses) {
        return $meses < 12 ? ($meses / 12) * ($salario * 0.65) + $salario : $salario * 1.65;
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
