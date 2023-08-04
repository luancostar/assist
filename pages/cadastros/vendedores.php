<?php
require_once '../../database/index.php';
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: ../../index.php');
}

function getEnderecos($db)
{
    $enderecos = [];
    $sql = "SELECT * FROM enderecos";
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) {
        $enderecos[] = $row;
    }

    return $enderecos;
}
function getVendedores($db)
{
    $vendedores = [];
    $sql = "SELECT enderecos.endereco AS endereco_vendedor, vendedores.*
            FROM vendedores
            LEFT JOIN enderecos ON enderecos.id = vendedores.id_endereco";

    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) {
        $vendedores[] = $row;
    }

    return $vendedores;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <form action="../../functions/cadastrar_vendedor.php" method="post">

        NOME DO VENDEDOR: <input type="text" name="nome" placeholder="Nome do vendedor">
        EMAIL: <input type="email" name="email" placeholder="Email">
        SENHA: <input type="password" name="senha" placeholder="Senha">

        ENDEREÇO DO VENDEDOR: <select name="id_endereco">
            <?php foreach (getEnderecos($db) as $endereco) : ?>
                <option value="<?= $endereco['id'] ?>"><?= $endereco['endereco'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <table>
        <?php foreach (getVendedores($db) as $vendedor) : ?>
            <tr>
                <td><?= $vendedor['nome'] ?></td>
                <td><?= $vendedor['email'] ?></td>
                <td><?= $vendedor['endereco_vendedor'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>