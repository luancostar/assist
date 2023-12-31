<?php
require_once('database/index.php');
session_start();
$erros = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($_POST['email'] != '' && $_POST['senha'] != '') :
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db->real_escape_string($email);
    $db->real_escape_string($senha);

    $sql = "SELECT *
                FROM vendedores 
                WHERE email = ?";
    $stmt = $db->prepare($sql);

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      if ($row['senha'] == $senha) {
        unset($row['senha']);
        $_SESSION['vendedor'] = $row;
        $_SESSION['logado'] = true;

        header('Location: pages/home.php');
        exit;
      } else {
        $erros[] = 'Login inválido';
      }
    } else {
      $erros[] = 'Login inválido';
    }
  else :
    $erros[] = 'Todos os campos são obrigatórios';
  endif;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="img/assist-removebg-preview.png" rel="icon">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/index.css" />
  <title>assist</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="POST" class="sign-in-form">
          <h2 class="title" style="  font-family: 'Josefin Sans', sans-serif;">login</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="email" placeholder="Usuário" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" placeholder="Senha" />
          </div>
          <input type="submit" value="Login" class="btn solid" />

        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <div style="display: flex; align-items: center;" class="title-contents">
            <h3 class="title_title">assist</h3>
            <div class="tags-text">
              <p class="line-tag" style="color: #67b8ff">-</p>
              <p class="line-tag">-</p>
              <p class="line-tag" style="color: #00ff41">-</p>
            </div>
          </div>
          <p class="title_text">
            assistente pessoal de vendas, performance e métricas.
          </p>
        </div>
      </div>

    </div>

    <script src="js/app.js"></script>
</body>

</html>