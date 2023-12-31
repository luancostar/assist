<?php
require_once('../database/index.php');
session_start();

if (!isset($_SESSION['logado'])) {
    header('Location: ../index.php');
}

$vendedor = $_SESSION['vendedor'];

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

function verificaViagemEmAberto($db, $id_vendedor)
{
    $sql = "SELECT * 
            FROM viagens 
            WHERE id_vendedor = '$id_vendedor'
            AND status_visita = 0";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }
    return false;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assist</title>
    <link href="../img/assist-removebg-preview.png" rel="icon">
    <link rel="stylesheet" href="../css/home.css">
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
            <img style="width: 80px; margin-top: 100%;" src="../img/loadnobg.gif" alt="">
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
                <a href="home.html" class="btn-home">
                    <i style="color: #fff; filter: drop-shadow(2px 6px 6px black);" class="fas fa-map-marker-alt"></i>
                </a>
            </div>
            <div class="nav-content2">
                <a href="travels.php" class="btn-second">
                    <i style="color: #fff; filter: blur(1px);" class="fas fa-map-marked-alt"></i>
                </a>
            </div>
        </div>
    </nav>

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
    </style>
    <!-- fim da sessão de navegação -->

    <!-- CASO NÃO HAJA VIAGENS EM ABERTO, APARECERÁ A TELA DE NOVA VIAGEM -->
    <?php if (verificaViagemEmAberto($db, $vendedor['id']) == false) : ?>
        <!-- Parâmetro sensor é utilizado somente em dispositivos com GPS -->
        <form id="travel-form" method="POST" action="../functions/cadastrar_viagem.php">

            <table style="display: flex; justify-content: center; margin-top: 1rem; font-family: system-ui;" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr style="display: none;">
                        <td>
                            <label style="font-family: system-ui;" for="endereco "><strong>Endere&ccedil;o de origem</strong></label>
                            <br>
                            <input type="text" id="endereco" class="field" style="width: 300px;font-family: system-ui; font-weight: 500; padding: 4px" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="font-family: system-ui;" for="txtDestino"><strong>Endere&ccedil;o de destino</strong></label>
                            <br>
                            <select id="txtDestino" style="width: 310px;font-family: system-ui; font-weight: 500; padding: 4px" name="destino" id="">
                                <?php foreach (getEnderecos($db) as $endereco) : ?>
                                    <option value="<?= $endereco['endereco'] ?>" type="text" style="width: 300px;font-family: system-ui;
                                            font-weight: 500; padding: 4px; margin-bottom: 1rem; " class="field">
                                        <?= $endereco['nome'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="display: flex; justify-content: center;">
                            <button value="Calcular dist&acirc;ncia" onclick="CalculaDistancia()" type="button" class="button success">
                                Mapear <i class="fas fa-route"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="display: flex;
                    justify-content: center;
                    margin-top: 1rem;
                    margin-bottom: 1rem;"><span id="litResultado" style="border:2px solid #6e6e6e;
                        border-radius: 15px;
                        padding: 10px;
                        width: 80%;
                        background: #f0f0f0;
                    ">&nbsp;</span></div>
            <div style="display: flex;
                    justify-content: center;
                    position: absolute;
                    bottom: 0px;
                    width: 100%;
                    ">
                <iframe style="height: 18rem; width: 100%;
                            border-top: 5px solid gray;" frameborder="0" id="map" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d63700.02337731988!2d-38.534133324833114!3d-3.75534313672112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbr!4v1691088013958!5m2!1sen!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div style="display: flex; align-items: center; justify-content:center">
                <button style="background-color: #5098bc; display: flex; align-items: center; justify-content: space-evenly;" value="" type="submit" class="button success">
                    Iniciar <i class="fas fa-car"></i>
                </button>
            </div>
            <input type="hidden" name="id_vendedor" value="<?= $vendedor['id'] ?>">
        </form>
    <?php else : ?>
        <form action="../functions/finalizar_viagem.php" method="post">
            <?php $id_viagem = verificaViagemEmAberto($db, $vendedor['id']) ?>
            <textarea name="obs" id="" placeholder="OBSERVAÇÃO" cols="30" rows="10"></textarea><br>
            STATUS VISITA <br>

            EFETUADA
            <input type="radio" name="status_visita" value="1">
            NÃO EFETUADA
            <input type="radio" name="status_visita" value="2">

            <input type="hidden" name="id_viagem" value="<?= $id_viagem ?>">

            <button type="submit">Finalizar viagem</button>
        </form>
    <?php endif; ?>
    <script src="../js/btn-loading.js"></script>
    <script src="../js/find-location.js"></script>
    <script src="../js/callback.js"></script>


</body>

</html>