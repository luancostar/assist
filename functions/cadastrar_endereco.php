<?php
require_once '../database/index.php';

$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$tipo_endereco = $_POST['tipo_endereco'];

$db->real_escape_string($nome);
$db->real_escape_string($endereco);
$db->real_escape_string($tipo_endereco);

$sql = "INSERT INTO enderecos(nome, endereco, tipo_endereco)
        VALUES (?, ?, ?)";

$stmt = $db->prepare($sql);
$stmt->bind_param('ssi', $nome, $endereco, $tipo_endereco);
$stmt->execute();

$stmt->close();
$db->close();

header('Location: ../pages/cadastros/enderecos.php');
exit;
