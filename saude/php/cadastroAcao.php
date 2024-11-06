<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de campanhas</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="icon" href="../img/logo atend+.png" type="image/x-icon">
</head>
<body>
    
<nav>
    <a href="listaAcao.php">Voltar</a>
</nav>
    <H1>Cadastro de campanhas</H1>
    <form action="cadastrarAcao.php" method="post">

    <label for="nomeAcao">Nome da campanha:</label>
    <input type="text" name="nomeAcao" id="nomeAcao"  required>

    <label for="dataAcao">Data da campanha:</label>
    <input type="date" name="dataAcao" id="dataAcao"  required>

    <label for="local">Local:</label>
    <input type="text" name="local" id="local"  required>


    <label for="tipoAcao">Tipo:</label>
    <input type="text" name="tipoAcao" id="tipoAcao"  required>

 



    <button type="submit">Salvar</button>
    </form>


</body>
</html>

<?php 




?>