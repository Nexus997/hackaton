<?php 
// Configurações de conexão
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

// Verifica se existe uma busca
$nomeBusca = isset($_POST['nomeBusca']) ? $_POST['nomeBusca'] : '';
$sql = "SELECT * FROM acoes WHERE nomeAcao LIKE ?";
$stmt = mysqli_prepare($conn, $sql);
$searchParam = "%" . $nomeBusca . "%";
mysqli_stmt_bind_param($stmt, 's', $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Campanhas</title>
    <link rel="icon" href="../img/logo atend+.png" type="image/x-icon">

    <link rel="stylesheet" href="css/lista_Acao.css"> <!-- Link para o CSS externo -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="logo">
    <img src="../img/logo atend+.png">
    <img src="../img/Atend+.png">
</div>
<h1>Lista de Campanhas</h1>
<div class="filtros-container">
    <input type="text" id="nomeBusca" placeholder="Buscar por nome..." onkeyup="buscarAcoes()">
    <form id="cadastroAcaoForm" action="cadastroAcao.php" method="post" style="display: inline;">
        <button type="submit">Cadastrar Campanha</button>
    </form>
</div>
<div id="resultados">
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nome da Campanha</th>
                    <th>Data da Campanha</th>
                    <th>Tipo de Campanha</th>
                    <th>Local</th>
                    <th></th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            // Formatar a data para o padrão brasileiro
            $dataAcao = date('d/m/Y', strtotime($row['dataAcao']));

            echo "<tr>
                    <td>{$row['nomeAcao']}</td>
                    <td>{$dataAcao}</td>
                    <td>{$row['tipoAcao']}</td>
                    <td>{$row['localAcao']}</td>
                    <td>
                        <form action='listaPaciente.php' method='post'>
                            <input type='hidden' name='idAcao' value='{$row['idAcao']}'>
                            <button type='submit'>Lista de Pacientes</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma Campanha encontrada.";
    }

    mysqli_close($conn);
    ?>
</div>

<script>
    function buscarAcoes() {
        var nomeBusca = $("#nomeBusca").val();

        $.ajax({
            url: 'buscar_acoes.php',
            type: 'POST',
            data: { 
                nomeBusca: nomeBusca
            },
            success: function(response) {
                $("#resultados").html(response);
            }
        });
    }
</script>

</body>
</html>
