<?php
require_once '../database/index.php';

$obs = $_POST['obs'];
$status_visita = $_POST['status_visita'];
$id_viagem = $_POST['id_viagem'];

$sql = "UPDATE viagens
        SET status_visita = '$status_visita', obs = '$obs', fim = NOW()
        WHERE id = '$id_viagem'";
$db->query($sql);

$db->close();
header('Location: ../pages/home.php');
