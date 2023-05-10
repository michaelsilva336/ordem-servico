<?php

  include_once("models/Service.php");
  include_once("models/User.php");
  include_once("models/Message.php");
  include_once("dao/UserDAO.php");
  



  class ServiceDAO implements ServiceDAOInterface {


    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }




    public function bildService($data){

        $service= new Service();

        $service->id= $data["id"];
        $service->name= $data["name"];
        $service->value= $data["value"];
        $service->description= $data["description"];
        $service->entry_date= $data["entry_date"];
        $service->users_id= $data["users_id"];
        
       
        return $service;

    }


    public function create(Service $service){

        $stmt= $this->conn->prepare("INSERT INTO services (name, value, description, users_id) VALUES (:name, :value, :description, :users_id)");


        $stmt->bindParam(":name", $service->name);
        $stmt->bindParam(":value", $service->value);
        $stmt->bindParam(":description", $service->description);    
        $stmt->bindParam(":users_id", $service->users_id);
        
        $stmt->execute();

        $this->message->setMessage("Serviço adicionado com sucesso!", "success", "services.php");

    }



    public function update(Service $service, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE services SET name= :name, value= :value, description= :description WHERE id= :id");

        $stmt->bindParam(":name", $service->name);
        $stmt->bindParam(":value", $service->value);
        $stmt->bindParam(":description", $service->description);
        $stmt->bindParam(":id", $service->id);

        $stmt->execute();

        if($redirect){

            $this->message->setMessage("Serviço editado com sucesso!", "success", "services.php");
        }
        
    }


    public function getServices(){

        $services= [];

        $stmt= $this->conn->query("SELECT * FROM services ORDER BY name");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $service){
                $services[]= $this->bildService($service);
            }

        }

        return $services;

    }



    public function findById($id){

        $userDao= new UserDAO($this->conn, $this->url);


        $stmt= $this->conn->prepare("SELECT * FROM services WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $service= $this->bildService($array);
            $userData= $userDao->findById($service->users_id);

            $service->user_name= $userData->user;

            return $service;

        }else{
            return false;
        }
        

   }


   public function findByName($name){

        $stmt= $this->conn->prepare("SELECT * FROM services WHERE name= :name");

        $stmt->bindParam(":name", $name);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data= $stmt->fetch();

            $service= $this->bildService($data);

            return $service;

        }else{
            return false;
        }
   }



   public function findByNameSearch($name){
      
    $names= [];

    $stmt= $this->conn->prepare("SELECT * FROM services WHERE name LIKE :name");

    $stmt->bindValue(":name", '%'.$name.'%');

    $stmt->execute();

      if($stmt->rowCount() > 0){
        
        $nameArray= $stmt->fetchAll();

        foreach($nameArray as $name){
          $names[] = $this->bildService($name); 
      }
    }

    return $names;
   }







}

