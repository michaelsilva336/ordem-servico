<?php

  include_once("dao/ClientDAO.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/VehicleDAO.php");
  include_once("dao/OsDAO.php");
  include_once("models/Message.php");




  class Complete {

    private $conn;
    private $url;
    private $message;
    

    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
        
    }


    public function autoComplete($name, $table, $dao){

        $classDao= new $dao($this->conn, $this->url);


        $data= [];

        $stmt= $this->conn->prepare("SELECT name FROM $table WHERE name LIKE :name ORDER BY name ASC LIMIT 5 ");

        $stmt->bindValue(":name", '%'.$name.'%');

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $name){

                $data[]= $name["name"];
            }
      
            return($data);
            
      
        }else{
            $this->message->setMessage("Nenhum nome encontrado", "error", "index.php");
        }



    }
    


  }