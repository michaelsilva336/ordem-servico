<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Vehicle.php");
  require_once("models/Message.php");
  require_once("models/Delete.php");
  require_once("dao/UserDAO.php");
  require_once("dao/VehicleDAO.php");
  require_once("dao/ClientDAO.php");
  require_once("dao/OsDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $clientDao = new ClientDAO($conn, $BASE_URL);
  $vehicleDao = new VehicleDAO($conn, $BASE_URL);
  $osDao = new OsDAO($conn, $BASE_URL);
  $delete = new Delete($conn, $BASE_URL);


  $type = filter_input(INPUT_POST, "type");
  $client_id= filter_input(INPUT_POST, "id-client");
  

  $userData = $userDao->verifyToken(true);


  if($type === "create"){

    $name= filter_input(INPUT_POST, "name");
    $brand= filter_input(INPUT_POST, "brand");
    $model= filter_input(INPUT_POST, "model");
    $plate= filter_input(INPUT_POST, "plate");

    
    $vehicle= new Vehicle();


    if(!empty($name) && !empty($brand) && !empty($model) && !empty($plate)){
    
    $vehicle->name= $name;
    $vehicle->brand= $brand;
    $vehicle->model= $model;
    $vehicle->plate= $plate;
    $vehicle->clients_id= $client_id;
    
    $vehicleDao->create($vehicle, $client_id);

    }else{
        $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
    }

   



  
  }else if($type === "update"){


    $name= filter_input(INPUT_POST, "name");
    $brand= filter_input(INPUT_POST, "brand");
    $model= filter_input(INPUT_POST, "model");
    $plate= filter_input(INPUT_POST, "plate");
    $id_vehicle= filter_input(INPUT_POST, "id-vehicle");

    //Verifica novamente o id
    $vehicleData= $vehicleDao->findById($id_vehicle);

    $clientData= $clientDao->findById($vehicleData->clients_id);

    if ($vehicleData) {

      if(!empty($name) && !empty($brand) && !empty($model) && !empty($plate)){

        $vehicleData->name= $name;
        $vehicleData->brand= $brand;
        $vehicleData->model= $model;
        $vehicleData->plate= $plate;
        $vehicleData->id= $vehicleData->id;

        $vehicleDao->update($vehicleData, "Veículo editado com sucesso", "vehicles.php?id=" . $clientData->id, true);


      }else{
        $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
      }

    }else{
      $message->setMessage("Veículo não encontrado", "error", "index.php");
    }





  }else if($type === "vehicle-os"){
    
    $id_client= filter_input(INPUT_POST, "id-client");
    $id_vehicle_os= filter_input(INPUT_POST, "id-vehicle-os");
    $id_os_vehicle= filter_input(INPUT_POST, "id-os-vehicle");
    


  
    $vehicle_os= $vehicleDao->findById($id_vehicle_os);


    if($vehicle_os){

      $vehicleChoose= $vehicleDao->findByChoose("true", $id_client);
      
      if($vehicleChoose){

        foreach($vehicleChoose as $vehicle){

          $vehicle->choose= "";
          $vehicleDao->update($vehicle, "" , "back", false);
        }
      }

      $vehicle_os->choose= "true";
      $vehicle_os->id= $id_vehicle_os;

      $vehicleDao->update($vehicle_os, "Veículo escolhido com sucesso", "back", true);

      $osData= $osDao->findById($id_os_vehicle);
      $osDao->updateVehicle($osData->id, $vehicle_os->name, $vehicle_os->plate);
      
  

    }else{
      $message->setMessage("Veículo não encontrado", "error", "index.php");
      
    }




  
  }else if($type === "delete"){

    
    $id_vehicle_delete= filter_input(INPUT_POST, "id-vehicle-delete");

    $vehicle= $vehicleDao->findById($id_vehicle_delete);

    if($vehicle){

      $delete->destroy($vehicle->id, "vehicles", "Veículo excluido com sucesso!");

    }else{
      $message->setMessage("Informações inválidas!", "error", "login.php");
    }
  

  }else{
    $message->setMessage("Informações inválidas!", "error", "index.php");
  }