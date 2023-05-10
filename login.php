<?php

  include_once("db.php");
  include_once("globals.php");
  include_once("models/User.php");
  include_once("dao/UserDAO.php");
  include_once("models/Message.php");

  $userDao= new UserDAO($conn, $BASE_URL);
  $message= new Message($BASE_URL);

  if(!empty($_SESSION["token"])){
    $userDao->destroyToken();
  }
  
  $flassMessage = $message->getMessage();

  if(!empty($flassMessage["msg"])) {
    // Limpar a mensagem
    $message->clearMessage();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistemas M</title>
  <link rel="short icon" href="<?= $BASE_URL ?>/img/favicon_m.png" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- CSS do projeto -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>/css/styles.css">
</head>
<body>
  <div class="container" id="login-container">
    
  <?php if(!empty($flassMessage["msg"])): ?>
    <div class="msg-container">
      <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
    </div>
  <?php endif; ?>
  
    <div class="row">
      <form action="<?= $BASE_URL ?>/auth_user.php" method="POST" id="form-login">
        <input type="hidden" name="type" value="login">
        <div class="form-group">
          <label for="user">Usuário:</label>
          <input class="form-control" type="text" id="user" name="user" placeholder="Digite seu nome de usuário">
        </div>
        <div class="form-group">
          <label for="password">Senha:</label>
          <input class="form-control" type="password" id="password" name="password" placeholder="Digite sua senha">
        </div>
        <input class="btn card-btn" type="submit" value="Entrar">
      </form>
    </div>
  </div>
</body>
</html>


   