<?php
require_once '../database/index.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$id_endereco = $_POST['id_endereco'];

$db->real_escape_string($nome);
$db->real_escape_string($email);
$db->real_escape_string($senha);
$db->real_escape_string($id_endereco);

$sql = "INSERT INTO vendedores(nome, email, senha, endereco)
        VALUES (?, ?, ?, ?)";

$stmt = $db->prepare($sql);
$stmt->bind_param('sssi', $nome, $email, $senha, $id_endereco);
$stmt->execute();

$stmt->close();
$db->close();

header('Location: ../pages/cadastros/vendedores.php');
exit;
