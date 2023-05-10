<?php

  include_once("db.php");
  include_once("globals.php");
  include_once("models/User.php");
  include_once("dao/UserDAO.php");
  include_once("models/Message.php");

  $userDao= new UserDAO($conn, $BASE_URL);
  $message= new Message($BASE_URL);
  
  $userData = $userDao->verifyToken(true);

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
  <title>Mecânica JJ</title>
  <link rel="short icon" href="<?= $BASE_URL ?>/img/favicon_m.png" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- CSS do projeto -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>/css/styles.css">
  <link rel="stylesheet" href="" data-href="css/pretoebranco.css" id="link-pretoebranco" >
  <!-- JS do projeto -->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <header>
    <nav id="main-navbar" class="navbar navbar-expand-lg">
        <div class="col-2" id="brand">
            <a href="<?=$BASE_URL?>" class="navbar-brand"><img src="<?= $BASE_URL ?>/img/logo.png" alt="Mecanica JJ" id="logo"></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="col-8" id="coluna-2">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?=$BASE_URL?>/clients.php" class="nav-link"><i class="fa fa-user"> Clientes</i></a>
                </li>
                <li class="nav-item">
                    <a href="<?=$BASE_URL?>/products.php" class="nav-link"><i class="fa fa-cart-arrow-down"> Produtos</i></a>
                </li>
                <li class="nav-item">
                    <a href="<?=$BASE_URL?>/services.php" class="nav-link"><i class="fa fa-wrench"> Serviços</i></a>
                </li>
                <li class="nav-item">
                    <a href="<?=$BASE_URL?>/oss.php" class="nav-link"><i class="fa fa-tasks"> Os</i></a>
                </li>
                <!--<li class="nav-item">
                    <a href="<?=$BASE_URL?>/orcamento.php" class="nav-link"><i class="fa fa-bars"> Orçamento</i></a>
                </li>
                <li class="nav-item">
                    <a href="<?=$BASE_URL?>/configurations.php" class="nav-link"><i class="fa fa-cog"> Configurações</i></a>
                </li>-->
            </ul>
        </div>
        <div class="col-md-2" id="coluna-3">
            <div class="row">
                <div class="col-6" id="user-circle-container">
                    <a href="#" class="nav-link"><i class="fa fa-user-circle"></i></a>
                </div>
                <div class="col-6" id="user-name-container">
                    <a href="#"><span id="user-name"><?= $userData->name ?> </span></a>
                    <a href="<?=$BASE_URL?>/logout.php"><span id="exit">Sair</span></a>
                </div>
            </div>
        </div>
    </nav>
    </header>
    <?php if(!empty($flassMessage["msg"])): ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
        </div>
    <?php endif; ?>
