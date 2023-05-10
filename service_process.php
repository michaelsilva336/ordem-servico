<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Service.php");
  require_once("models/Message.php");
  require_once("models/Delete.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ServiceDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $serviceDao = new ServiceDAO($conn, $BASE_URL);
  $delete = new Delete($conn, $BASE_URL);


  $type = filter_input(INPUT_POST, "type");


  $userData = $userDao->verifyToken(true);


  if($type === "create"){

    $name= filter_input(INPUT_POST, "name");
    $value= filter_input(INPUT_POST, "value");
    $description= filter_input(INPUT_POST, "description");
    $users_id= $userData->id;
    $waiting= 6;

    $service= new Service();

    if(!empty($name) && !empty($value) && !empty($description)){

        $service->name= $name;
        $service->value= $value;
        $service->description= $description;
        $service->services_orders_id= $waiting;
        $service->users_id= $users_id;



        $serviceDao->create($service);


    }else{
        $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
    }

  
  }else if($type === "update"){


    $name= filter_input(INPUT_POST, "name");
    $value= filter_input(INPUT_POST, "value");
    $description= filter_input(INPUT_POST, "description");
    $id= filter_input(INPUT_POST, "id");

    //Verifica novamente o id
    $serviceData= $serviceDao->findById($id);

    if ($serviceData) {

      if(!empty($name) && !empty($value) && !empty($description)){

        $serviceData->name= $name;
        $serviceData->value= $value;
        $serviceData->description= $description;
        $serviceData->id= $id;

        $serviceDao->update($serviceData, true);


      }else{
        $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
      }

    }else{
      $message->setMessage("Serviço não encontrado", "error", "login.php");
    }

  
  
  }else if($type === "delete"){

    
    $id= filter_input(INPUT_POST, "id");

    $service= $serviceDao->findById($id);

    if($service){

      $delete->destroy($service->id, "services", "Serviço excluido com sucesso!");

    }else{
      $message->setMessage("Informações inválidas!", "error", "login.php");
    }
  

  }else{
    $message->setMessage("Informações inválidas!", "error", "login.php");
  }