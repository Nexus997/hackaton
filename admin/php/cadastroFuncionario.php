    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Funcionário</title>
        <link rel="stylesheet" href="../css/cadastro.css">
        <link rel="icon" href="../img/Admin+logo.png" type="image/x-icon">
    </head>
    <body>
    <nav class="voltar">
        <form action="listaFuncionario.php" method="post" style="display: inline;">
            <input type="hidden" name="idDepartamento" value="<?php echo ($_POST['idDepartamento']); ?>">
            <button class="voltarBtn" type="submit">Voltar</button>
        </form>
    </nav>

        <h1>Cadastro de Funcionário</h1>
        <form method="POST" action="cadastrarFuncionario.php">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="documento">CPF:</label>
            <input type="text" id="documento" name="documento" maxlength="14" required><br><br>

            <label for="dataNasc">Data de Nascimento:</label>
            <input type="date" id="dataNasc" name="dataNasc" required><br><br>

            <label for="dataAdmissao">Data de Admissão:</label>
            <input type="date" id="dataAdmissao" name="dataAdmissao" required><br><br>

            <label for="idDepartamento">Departamento:</label>
            <input type="hidden" id="idDepartamento" name="idDepartamento" value="<?php echo isset($_POST['idDepartamento']) ? htmlspecialchars($_POST['idDepartamento']) : ''; ?>">
            <span>
                <?php
                // Conexão com o banco de dados
                require_once('conn.php');
                $conn = mysqli_connect($servername, $username, $password, $dbname) or die('Erro ao conectar ao banco de dados');

                // Pega o nome do departamento correspondente ao ID passado por POST
                $idDepartamento = isset($_POST['idDepartamento']) ? $_POST['idDepartamento'] : null;
                if ($idDepartamento) {
                    $sql = "SELECT nomeDepartamento FROM departamento WHERE idDepartamento = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $idDepartamento);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $nomeDepartamento);
                    if (mysqli_stmt_fetch($stmt)) {
                        echo htmlspecialchars($nomeDepartamento); // Exibe o nome do departamento
                    } else {
                        echo "Departamento não encontrado.";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "ID do departamento não especificado.";
                }
                mysqli_close($conn);
                ?>
            </span><br><br>

            <label for="contato">Contato:</label>
            <input type="text" id="contato" name="contato" maxlength="15" minlength="14" required><br><br>

            <label for="salario">Salário (R$):</label>
            <input type="number" id="salario" name="salario" required><br><br>

            <button type="submit">Cadastrar Funcionário</button>
        </form>


    <script>
        // Função para formatar o CPF
        const contatoInput = document.getElementById('contato');

        contatoInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, ''); 

            if (value.length > 10) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3'); // Formato (XX) XXXXX-XXXX
            } else if (value.length > 6) {
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3'); // Formato (XX) XXXX-XXXX
            } else if (value.length > 2) {
                value = value.replace(/(\d{2})(\d{0,4})/, '($1) $2'); // Formato (XX) XXXX
            } else if (value.length <= 2) {
                value = value.replace(/(\d{0,2})/, '($1'); // Formato (XX
            }

            e.target.value = value; 
        });
        const cpfInput = document.getElementById('documento');

cpfInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico

    // Aplica a formatação de CPF: XXX.XXX.XXX-XX
    if (value.length > 10) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    } else if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3');
    } else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d{1,2})/, '$1.$2');
    }

    e.target.value = value; // Atualiza o valor do campo com a formatação
});
    </script>
    </body>
    </html>
