<?php
require_once('conn.php');

$conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

$nomeBusca = isset($_POST['nomeBusca']) ? $_POST['nomeBusca'] : '';
$sql = "SELECT * FROM acoes WHERE nomeAcao LIKE ?";
$stmt = mysqli_prepare($conn, $sql);
$searchParam = "%" . $nomeBusca . "%";
mysqli_stmt_bind_param($stmt, 's', $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Nome da Ação</th>
                <th>Data da Ação</th>
                <th>Tipo de Ação</th>
                <th>Local</th>
                <th></th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
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
    echo "Nenhuma ação encontrada.";
}

mysqli_close($conn);
?>
