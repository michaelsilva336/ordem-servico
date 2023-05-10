<?php

  include_once("templates/header.php");


  if(($userDao) && !empty($_SESSION["token"])){

    $userDao->destroyToken();

  }else{

    $message->setMessage("Faça o login primeiramente para acessar essa página", "error", "login.php");

  }
  

