<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Client.php");
  require_once("models/Message.php");
  require_once("models/Delete.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ClientDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $clientDao = new ClientDAO($conn, $BASE_URL);
  $delete = new Delete($conn, $BASE_URL);


  $type = filter_input(INPUT_POST, "type");


  $userData = $userDao->verifyToken(true);


  if($type === "create"){

    $name= filter_input(INPUT_POST, "name");
    $cpf= filter_input(INPUT_POST, "cpf");
    $phone= filter_input(INPUT_POST, "phone");
    $cell= filter_input(INPUT_POST, "cell");
    $email= filter_input(INPUT_POST, "email");
    $rua= filter_input(INPUT_POST, "rua");
    $number= filter_input(INPUT_POST, "number");
    $district= filter_input(INPUT_POST, "district");
    $city= filter_input(INPUT_POST, "city");
    $state= filter_input(INPUT_POST, "state");
    $cep= filter_input(INPUT_POST, "cep");
    $users_id= $userData->id;

    $client= new Client();

    if(!empty($name)){

        $client->name= $name;
        $client->cpf= $cpf;
        $client->phone= $phone;
        $client->cell= $cell;
        $client->email= $email;
        $client->rua= $rua;
        $client->number= $number;
        $client->district= $district;
        $client->city= $city;
        $client->state= $state;
        $client->cep= $cep;
        $client->users_id= $users_id;


        $clientDao->create($client);


    }else{
        $message->setMessage("é necessário adicionar pelo meno o Nome,", "error", "back");
    }

  
  }else if($type === "update"){


    $name= filter_input(INPUT_POST, "name");
    $cpf= filter_input(INPUT_POST, "cpf");
    $phone= filter_input(INPUT_POST, "phone");
    $cell= filter_input(INPUT_POST, "cell");
    $email= filter_input(INPUT_POST, "email");
    $rua= filter_input(INPUT_POST, "rua");
    $number= filter_input(INPUT_POST, "number");
    $district= filter_input(INPUT_POST, "district");
    $city= filter_input(INPUT_POST, "city");
    $state= filter_input(INPUT_POST, "state");
    $cep= filter_input(INPUT_POST, "cep");
    $id= filter_input(INPUT_POST, "id");

    //Verifica novamente o id
    $clientData= $clientDao->findById($id);

    if ($clientData) {

      if(!empty($name)){

        $clientData->name= $name;
        $clientData->cpf= $cpf;
        $clientData->phone= $phone;
        $clientData->cell= $cell;
        $clientData->email= $email;
        $clientData->rua= $rua;
        $clientData->number= $number;
        $clientData->district= $district;
        $clientData->city= $city;
        $clientData->state= $state;
        $clientData->cep= $cep;
        $clientData->id= $id;

        $clientDao->update($clientData, true);


      }else{
        $message->setMessage("é necessário adicionar pelo menos o nome", "error", "back");
      }

    }else{
      $message->setMessage("Cliente não encontrado", "error", "login.php");
    }

  
  
  }else if($type === "delete"){
      
      
    
    $id= filter_input(INPUT_POST, "id");

    $client= $clientDao->findById($id);
    
    if($client){

      $delete->destroy($client->id, "clients", "Cliente excluido com sucesso!");
      

    }else{
      $message->setMessage("Informações inválidas!", "error", "login.php");
    }
  

  }else{
    $message->setMessage("Informações inválidas!", "error", "login.php");
  }