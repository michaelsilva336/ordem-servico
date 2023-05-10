<?php

  include_once("models/Os.php");
  include_once("models/User.php");
  include_once("models/Client.php");
  include_once("dao/UserDAO.php");
  include_once("dao/ClientDAO.php");
  include_once("dao/ProductOsDAO.php");
  include_once("models/Message.php");




  class OsDAO implements OsDAOInterface {

    private $conn;
    private $url;
    private $message;



    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }



    public function bildOs($data){

        $os= new Os();

        $os->id= $data["id"];
        $os->date_start= $data["date_start"];
        $os->date_end= $data["date_end"];
        $os->responsible= $data["responsible"];
        $os->warranty= $data["warranty"];
        $os->defect= $data["defect"];
        $os->status= $data["status"];
        $os->observation= $data["observation"];
        $os->vehicle_client= $data["vehicle_client"];
        $os->vehicle_plate= $data["vehicle_plate"];
        $os->billed= $data["billed"];
        $os->clients_id= $data["clients_id"];
        $os->users_id= $data["users_id"];

        return $os;

    }



    public function create(Os $os){

        $stmt= $this->conn->prepare("INSERT INTO services_orders (date_start, date_end, responsible, warranty, defect, status, observation, clients_id, users_id) VALUES (:date_start, :date_end, :responsible, :warranty, :defect, :status, :observation, :clients_id, :users_id)");
        $stmt->bindParam(":date_start", $os->date_start);
        $stmt->bindParam(":date_end", $os->date_end);
        $stmt->bindParam(":responsible", $os->responsible);
        $stmt->bindParam(":warranty", $os->warranty);
        $stmt->bindParam(":defect", $os->defect);
        $stmt->bindParam(":status", $os->status);
        $stmt->bindParam(":observation", $os->observation);
        $stmt->bindParam(":clients_id", $os->clients_id);
        $stmt->bindParam(":users_id", $os->users_id);   

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $stmtId= $this->conn->query("SELECT MAX(id) FROM services_orders");

            $stmtId->execute();

            $data= $stmtId->fetch();

            $id= $data["MAX(id)"];

            $os= $this->findById($id);

        }
    
        $this->message->setMessage("Ordem de serviço criado com sucesso!", "success", "editos.php?id=" . $os->id);

    }



    public function update(Os $os, $redirect, $destiny){

        $stmt= $this->conn->prepare("UPDATE services_orders SET date_start= :date_start, date_end= :date_end, responsible= :responsible, warranty= :warranty, defect= :defect, status= :status, observation= :observation, billed= :billed WHERE id= :id");

        $stmt->bindParam(":date_start", $os->date_start);
        $stmt->bindParam(":date_end", $os->date_end);
        $stmt->bindParam(":responsible", $os->responsible);
        $stmt->bindParam(":warranty", $os->warranty);
        $stmt->bindParam(":defect", $os->defect);
        $stmt->bindParam(":status", $os->status);
        $stmt->bindParam(":observation", $os->observation);
        $stmt->bindParam(":billed", $os->billed);
        $stmt->bindParam(":id", $os->id);

        $stmt->execute();

        $osData= $this->findById($os->id);

        $productOsDao= new productOsDAO($this->conn, $this->url);


        if($osData->status === "Finalizado" && $osData->billed === ""){

          $productOsDao->inventoryDown($osData->id);
        
          }
          
        if($osData->billed === "true" && $osData->status != "Finalizado" ){
    
          $productOsDao->inventorySum($osData->id);
     
        }

        if($redirect){

            $this->message->setMessage("Dados editados com sucesso!", "success", $osData->status === "Finalizado" ? $destiny= "oss.php" : $destiny);
        }
        
    }



    public function updateVehicle($id_os, $vehicle_name, $vehicle_plate){

        $stmt= $this->conn->prepare("UPDATE services_orders SET vehicle_client= :vehicle_client, vehicle_plate= :vehicle_plate WHERE id= :id");

        $stmt->bindParam(":vehicle_client", $vehicle_name);
        $stmt->bindParam(":vehicle_plate", $vehicle_plate);
        $stmt->bindParam(":id", $id_os);

        $stmt->execute();


    }




    public function getOss(){
        
        $oss= [];

        $stmt= $this->conn->query("SELECT * FROM services_orders ORDER BY id DESC");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $os){
                $oss[]= $this->bildOs($os);
            }

        }

        return $oss;

    }


    public function findById($id){

        $userDao= new UserDAO($this->conn, $this->url);
        $clientDao= new ClientDAO($this->conn, $this->url);


        $stmt= $this->conn->prepare("SELECT * FROM services_orders WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $os= $this->bildOs($array);
            $userData= $userDao->findById($os->users_id);
            $clientData= $clientDao->findById($os->clients_id);

            $os->user_name= $userData->user;
            
            $os->client_id= $clientData->id;
            $os->client_name= $clientData->name;
            $os->client_rua= $clientData->rua;
            $os->client_number= $clientData->number;
            $os->client_city= $clientData->city;
            $os->client_phone= $clientData->phone;
            $os->client_cpf= $clientData->cpf;
            $os->client_district= $clientData->district;
            $os->client_cep= $clientData->cep;
            $os->client_email= $clientData->email;

            return $os;

        }else{
            return false;
        }
    }



    public function findByIdClient($id){

        $userDao= new UserDAO($this->conn, $this->url);
        $clientDao= new ClientDAO($this->conn, $this->url);

        $stmt= $this->conn->prepare("SELECT * FROM services_orders WHERE clients_id= :clients_id");

        $stmt->bindParam(":clients_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $os= $this->bildOs($array);
            $userData= $userDao->findById($os->users_id);
            $clientData= $clientDao->findById($os->clients_id);

            $os->user_name= $userData->user;
            
            $os->client_id= $clientData->id;
            $os->client_name= $clientData->name;
            $os->client_rua= $clientData->rua;
            $os->client_number= $clientData->number;
            $os->client_city= $clientData->city;
            $os->client_phone= $clientData->phone;
            $os->client_cpf= $clientData->cpf;
            $os->client_district= $clientData->district;
            $os->client_cep= $clientData->cep;
            $os->client_email= $clientData->email;

            return $os;

        }else{
            return false;
        }
    }



    public function findByNameSearch($name){
      
        $names= [];
    
        $stmt= $this->conn->prepare("SELECT * FROM services_orders WHERE name LIKE :name");
    
        $stmt->bindValue(":name", '%'.$name.'%');
    
        $stmt->execute();
    
          if($stmt->rowCount() > 0){
            
            $nameArray= $stmt->fetchAll();
    
            foreach($nameArray as $name){
              $names[] = $this->bildProduct($name); 
          }
        }
    
        return $names;
    }






    public function findByIdClientSeach($id){

        $os= [];

        $userDao= new UserDAO($this->conn, $this->url);
        $clientDao= new ClientDAO($this->conn, $this->url);

        $stmt= $this->conn->prepare("SELECT * FROM services_orders WHERE clients_id= :clients_id");

        $stmt->bindParam(":clients_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetchALL();

            foreach($array as $name){
                $os[] = $this->bildOs($name); 
            }   

            return $os;

        }else{
            return false;
        }
    }



  }