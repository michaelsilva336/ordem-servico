<?php

  include_once("models/Vehicle.php");
  include_once("models/User.php");
  include_once("models/Message.php");
  include_once("dao/UserDAO.php");
  include_once("dao/ClientDAO.php");



  class VehicleDAO implements VehicleDAOInterface{

    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }




    public function bildVehicle($data){

        $vehicle= new Vehicle();

        $vehicle->id= $data["id"];
        $vehicle->name= $data["name"];
        $vehicle->brand= $data["brand"];
        $vehicle->model= $data["model"];
        $vehicle->plate= $data["plate"];
        $vehicle->choose= $data["choose"];
        $vehicle->date_entry= $data["date_entry"];
        $vehicle->clients_id= $data["clients_id"];
        
        return $vehicle;

    }



    public function create(Vehicle $vehicle, $client_id){

        $clientDao= new ClientDAO($this->conn, $this->url);

        $stmt= $this->conn->prepare("INSERT INTO vehicles (name, brand, model, plate, clients_id) VALUES (:name, :brand, :model, :plate, :clients_id)");


        $stmt->bindParam(":name", $vehicle->name);
        $stmt->bindParam(":brand", $vehicle->brand);
        $stmt->bindParam(":model", $vehicle->model);
        $stmt->bindParam(":plate", $vehicle->plate);   
        $stmt->bindParam(":clients_id", $vehicle->clients_id);
        
        $stmt->execute();

        $clientData= $clientDao->findById($client_id);

        $this->message->setMessage("Veículo adicionado com sucesso!", "success", "vehicles.php?id=" . $clientData->id);

    }




    public function update(Vehicle $vehicle, $msg, $destiny, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE vehicles SET name= :name, brand= :brand, model= :model, plate= :plate, choose= :choose WHERE id= :id");

        $stmt->bindParam(":name", $vehicle->name);
        $stmt->bindParam(":brand", $vehicle->brand);
        $stmt->bindParam(":model", $vehicle->model);
        $stmt->bindParam(":plate", $vehicle->plate);
        $stmt->bindParam(":choose", $vehicle->choose);
        $stmt->bindParam(":id", $vehicle->id);
        
        $stmt->execute();

        if($redirect){
            $this->message->setMessage($msg, "success", $destiny);
        }
        


    }

    public function getVehicles(){

        $vehicles= [];

        $stmt= $this->conn->query("SELECT * FROM vehicles");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $vehicle){
                $vehicles[]= $this->bildVehicle($vehicle);
            }

        }

        return $vehicles;


    }



    public function findById($id){

        $stmt= $this->conn->prepare("SELECT * FROM vehicles WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $vehicle= $this->bildVehicle($array);

            return $vehicle;

        }else{
            return false;
        }

    }



    public function findByClient($id){

        $vehicles= [];

        $stmt= $this->conn->prepare("SELECT * FROM vehicles WHERE clients_id= :clients_id");

        $stmt->bindParam(":clients_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetchAll();

            foreach($array as $vehicle){

                $vehicles[]= $this->bildVehicle($vehicle);
            }

            return $vehicles;

        }else{
            return false;
        }

    }


    public function findByChoose($choose, $id){

        $vehicles= [];

        $stmt= $this->conn->prepare("SELECT * FROM vehicles WHERE choose= :choose AND clients_id= :clients_id");

        $stmt->bindParam(":choose", $choose);
        $stmt->bindParam(":clients_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetchAll();

            foreach($array as $vehicle){

                $vehicles[]= $this->bildVehicle($vehicle);
            }

            return $vehicles;

        }else{
            return false;
        }

    }


  }