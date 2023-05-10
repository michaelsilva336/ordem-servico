<?php

  include_once("db.php");
  include_once("globals.php");
  include_once("models/User.php");
  include_once("models/Message.php");
  include_once("dao/UserDAO.php");

  $user= new User();
  $message= new Message($BASE_URL);
  $userDao= new UserDAO($conn, $BASE_URL);

  
  $type= filter_input(INPUT_POST, "type");





  $espera= "S";

  
  if($espera === "N"){

    $passwordForm= "123";

    $finalPassword= $user->generatePassword($passwordForm);

    $user->name= "Teste";
    $user->user= "teste";
    $user->password= $finalPassword;
    $user->priority= "S";

    $userDao->create($user);







  }else if($type === "login"){

    $user= filter_input(INPUT_POST, "user");
    $password= filter_input(INPUT_POST, "password");

    if($userDao->authenticateUser($user, $password)){

      $message->setMessage("Login efetuado com sucesso", "success", "index.php");

    }else{
      $message->setMessage("Usuário ou senha não encontrados!", "error", "back");
    }


  }else{
    $message->setMessage("Informações inválidas", "error", "login.php");
  }




  

  
