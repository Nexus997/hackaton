<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
</head>
<body>
    <form action="cadastrarPaciente.php" method="post">

    <label for="nomePaciente">Nome do paciente:</label>
    <input type="text" name="nomePaciente" id="nomePaciente">

    <label for="dataNasc">Data de nascimento:</label>
    <input type="date" name="dataNasc" id="dataNasc">

    <label for="bairro">Bairro:</label>
    <input type="text" name="bairro" id="bairro">

    <label for="generoPaciente">Gênero do paciente:</label>
    <select name="generoPaciente" id="generoPaciente">
        <option value="" disabled selected hidden>Selecione o gênero do paciente</option>
        <option value="M">Masculino</option>
        <option value="F">Feminino</option>
    </select>

    <label for="statusTrabalhista">Situação trabalhista:</label>
    <select name="statusTrabalhista" id="statusTrabalhista">
        <option value="" disabled selected hidden>Selecione a situação trabalhista</option>
        <option value="Empregado">Empregado</option>
        <option value="Autônomo">Autônomo</option>
        <option value="Desempregado">Desempregado</option>
        <option value="Estagiário">Estagiário</option>
        <option value="Aposentado">Aposentado</option>
        <option value="Pensionista">Pensionista</option>
        <option value="Licença">Licença</option>
    </select>

    <label for="contatoPaciente">Contato:</label>
    <input type="text" name="contatoPaciente" id="contatoPaciente">

    <label for="documentoPaciente">Documento (RG ou SUS):</label>
    <input type="text" name="documentoPaciente" id="documentoPaciente"> 

    <label for="observacoesPaciente">Observações do paciente</label>
    <textarea name="observacoesPaciente" id="observacoesPaciente"></textarea>



    <button type="submit">Salvar</button>
    </form>


    <script>
        const contatoInput = document.getElementById('contatoPaciente');

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


        const documentoInput = document.getElementById('documentoPaciente');

documentoInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (value.length === 9) {
        // Formato RG: xx.xxx.xxx-x
        value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');
    } else if (value.length === 15) {
        // Formato SUS: xxx xxxx xxxx xxxx
        value = value.replace(/(\d{3})(\d{4})(\d{4})(\d{4})/, '$1 $2 $3 $4');
    }

    e.target.value = value; // Atualiza o valor do input
});
    </script>
</body>
</html>

<?php 




?>