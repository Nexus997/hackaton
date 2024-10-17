<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Ação</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    
<nav>
    <a href="listaAcao.php">Voltar</a>
</nav>
    <H1>Cadastro de Ação</H1>
    <form action="cadastrarAcao.php" method="post">

    <label for="nomeAcao">Nome do ação:</label>
    <input type="text" name="nomeAcao" id="nomeAcao" required>

    <label for="dataAcao">Data da ação:</label>
    <input type="date" name="dataAcao" id="dataAcao" required>

    <label for="local">Local:</label>
    <input type="text" name="local" id="local" required>


    <label for="tipoAcao">Tipo:</label>
    <input type="text" name="tipoAcao" id="tipoAcao" required>

 



    <button type="submit">Salvar</button>
    </form>


</body>
</html>

<?php 




?>