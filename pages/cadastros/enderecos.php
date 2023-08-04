<?php
require_once '../../database/index.php';
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: ../../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="../../functions/cadastrar_endereco.php" method="post">

        IDENTIFICAÇÃO DO ENDEREÇO:
        <input type="text" name="nome" placeholder="Identificação do endereço">

        ENDEREÇO:
        <input type="text" name="endereco" placeholder="Endereço">

        TIPO DE ENDEREÇO:
        <select name="tipo_endereco">
            <option value="1">Empresa</option>
            <option value="2">Residencial</option>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

</body>

</html>