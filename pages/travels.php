<?php
require_once('../database/index.php');
session_start();

if (!isset($_SESSION['logado'])) {
    header('Location: ../index.php');
}

$vendedor = $_SESSION['vendedor'];

function getViagensVendedor($db, $id_vendedor)
{
    $viagens = [];
    $sql = "SELECT enderecos.nome AS endereco_destino, vendedores.nome, viagens.*
            FROM viagens
            LEFT JOIN enderecos ON viagens.id_destino = enderecos.id
            LEFT JOIN vendedores ON viagens.id_vendedor = vendedores.id
            WHERE vendedores.id = '$id_vendedor'";

    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) {
        $viagens[] = $row;
    }
    return $viagens;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assist</title>
    <link href="../img/assist-removebg-preview.png" rel="icon">
    <link rel="stylesheet" href="../css/travels.css">
    <script src="https://kit.fontawesome.com/7a8d54eabc.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.8.1.js" type="text/javascript"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeIdizfHx0Td0JpPHcio20F8v7CssB2Kk"></script>

    <script>
        // Função para habilitar a interação após 3 segundos
        function habilitarInteracao() {
            // Esconde a div de aviso após 3 segundos
            const avisoDiv = document.getElementById('avisoDiv');
            avisoDiv.style.display = 'none';

            // Coloque aqui o código que habilita a interação na página
            // Por exemplo, você pode mostrar botões que estavam ocultos
            console.log("A interação está habilitada agora!");
        }

        // Mostra a div de aviso ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            // Aguarda 3 segundos (3000 milissegundos) antes de chamar a função para habilitar a interação
            setTimeout(habilitarInteracao, 3000);
        });
    </script>
</head>

<body>
    <div class="aviso" id="avisoDiv">
        <div class="load">
            <img style="width: 80px; margin-top: 100%;" src="/img/loadnobg.gif" alt="">
        </div>
    </div>

    <nav class="nav-up">
        <div class="nav-header1">
            <div class="nav-content1">
                <img class="user-avatar" src="../img/avatar.png" alt="">
            </div>
            <div class="nav-content2">
                <p class="user-name"><?= $vendedor['nome'] ?></p>
            </div>
        </div>
    </nav>
    <nav class="nav-down">
        <div class="nav-header2">
            <div class="nav-content1">
                <a href="home.php" class="btn-home">
                    <i style="color: #fff; filter: blur(1px);" class="fas fa-map-marker-alt"></i>
                </a>
            </div>
            <div class="nav-content2">
                <a href="travels.php" class="btn-second">
                    <i style="color: #fff; filter: drop-shadow(2px 6px 6px black);" class="fas fa-map-marked-alt"></i>
                </a>
            </div>
        </div>
    </nav>
    <div class="all-content">
        <style>
            /* Estilize a div de aviso como quiser */
            .aviso {
                background-color: rgba(185, 185, 185, 0.836);
                padding: 10px;
                text-align: center;
                font-size: 18px;
                display: block;
                position: absolute;
                height: 100vh;
                width: 100vw;
                z-index: 999;
                overflow: hidden;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        </style>

        <table style="width:100%">
            <tr>
                <th>Origem</th>
                <th>Destino</th>
                <th>Status da visita</th>
                <th>Observação</th>
                <th>Distância</th>
                <th>Início</th>
                <th>Fim</th>
            </tr>
            <?php foreach (getViagensVendedor($db, $vendedor['id']) as $viagem) : ?>
                <tr>
                    <td><?= $viagem['origem'] ?></td>
                    <td><?= $viagem['endereco_destino'] ?></td>
                    <td><?= $viagem['status_visita'] == 1 ? "Efetuada" : "Não efetuada" ?></td>
                    <td><?= $viagem['obs'] ?></td>
                    <td><?= number_format($viagem['distancia'], 1, ".", "")  ?> km</td>
                    <td><?= date("d/m/Y - h:i", strtotime($viagem['inicio']))  ?></td>
                    <td><?= date("d/m/Y - h:i", strtotime($viagem['fim']))  ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <script src="../js/btn-loading.js"></script>
        <script src="../js/callback.js"></script>
        <script src="../js/find-location.js"></script>
        <script src="../js/change-section.js"></script>

</body>

</html>