<?php

  include_once("models/Client.php");
  include_once("models/User.php");
  include_once("dao/UserDAO.php");
  include_once("models/Message.php");




  class ClientDAO implements ClientDAOInterface {

    private $conn;
    private $url;
    private $message;



    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }



    public function bildClient($data){

        $client= new Client();

        $client->id= $data["id"];
        $client->name= $data["name"];
        $client->cpf= $data["cpf"];
        $client->phone= $data["phone"];
        $client->cell= $data["cell"];
        $client->email= $data["email"];
        $client->rua= $data["rua"];
        $client->number= $data["number"];
        $client->district= $data["district"];
        $client->city= $data["city"];
        $client->state= $data["state"];
        $client->cep= $data["cep"];
        $client->entry_date= $data["entry_date"];
        $client->users_id= $data["users_id"];

        return $client;

    }



    public function create(Client $client){

        $stmt= $this->conn->prepare("INSERT INTO clients (name, cpf, phone, cell, email, rua, number, district, city, state, cep, users_id) VALUES (:name, :cpf, :phone, :cell, :email, :rua, :number, :district, :city, :state, :cep, :users_id)");

        $stmt->bindParam(":name", $client->name);
        $stmt->bindParam(":cpf", $client->cpf);
        $stmt->bindParam(":phone", $client->phone);
        $stmt->bindParam(":cell", $client->cell);
        $stmt->bindParam(":email", $client->email);
        $stmt->bindParam(":rua", $client->rua);
        $stmt->bindParam(":number", $client->number);
        $stmt->bindParam(":district", $client->district);
        $stmt->bindParam(":city", $client->city);
        $stmt->bindParam(":state", $client->state);
        $stmt->bindParam(":cep", $client->cep);
        $stmt->bindParam(":users_id", $client->users_id);   

        $stmt->execute();

        $this->message->setMessage("Cliente adicionado com sucesso!", "success", "clients.php");

    }



    public function update(Client $client, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE clients SET name= :name, cpf= :cpf, phone= :phone, cell= :cell, email= :email, rua= :rua, number= :number, district= :district, city= :city, state= :state, cep= :cep WHERE id= :id");

        $stmt->bindParam(":name", $client->name);
        $stmt->bindParam(":cpf", $client->cpf);
        $stmt->bindParam(":phone", $client->phone);
        $stmt->bindParam(":cell", $client->cell);
        $stmt->bindParam(":email", $client->email);
        $stmt->bindParam(":rua", $client->rua);
        $stmt->bindParam(":number", $client->number);
        $stmt->bindParam(":district", $client->district);
        $stmt->bindParam(":city", $client->city);
        $stmt->bindParam(":state", $client->state);
        $stmt->bindParam(":cep", $client->cep);
        $stmt->bindParam(":id", $client->id);

        $stmt->execute();

        if($redirect){

            $this->message->setMessage("Dados editados com sucesso!", "success", "clients.php");
        }
        
    }

    public function getClients(){

        $clients= [];

        $stmt= $this->conn->query("SELECT * FROM clients ORDER BY name");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $client){
                $clients[]= $this->bildClient($client);
            }


        }

        return $clients;

    }





    public function findByNameSearch($name){
      
        $names= [];
  
        $stmt= $this->conn->prepare("SELECT * FROM clients WHERE name LIKE :name");
  
        $stmt->bindValue(":name", '%'.$name.'%');
  
        $stmt->execute();
  
          if($stmt->rowCount() > 0){
            
            $nameArray= $stmt->fetchAll();
  
            foreach($nameArray as $name){
              $names[] = $this->bildClient($name); 
          }
        }
  
        return $names;
  
  
      }





    public function findById($id){

        $userDao= new UserDAO($this->conn, $this->url);


        $stmt= $this->conn->prepare("SELECT * FROM clients  WHERE id= :id ");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $client= $this->bildClient($array);
            $userData= $userDao->findById($client->users_id);

            $client->user_name= $userData->user;

            return $client;

        }else{
            return false;
        }
    }




    public function findByName($name){

        $stmt= $this->conn->prepare("SELECT * FROM clients WHERE name= :name");

        $stmt->bindParam(":name", $name);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data= $stmt->fetch();

            $client= $this->bildClient($data);

            return $client;

        }else{
            return false;
        }

    }

  }