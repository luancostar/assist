<?php
require_once '../database/index.php';

$origem = $_POST['origem'];
$destino = $_POST['destino'];
$id_vendedor = $_POST['id_vendedor'];
$distancia = $_POST['distancia'] / 1000;

// BUSCA ID DO DESTINO
$sql = "SELECT id
        FROM enderecos
        WHERE endereco='$destino'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$id_destino = $row['id'];

// REGISTRA A NOVA VIAGEM
$sql = "INSERT INTO viagens(id_vendedor, origem, id_destino, distancia, inicio) VALUES('$id_vendedor','$origem','$id_destino','$distancia', NOW())";
$result = $db->query($sql);

$db->close();
header('Location: ../pages/home.php');
