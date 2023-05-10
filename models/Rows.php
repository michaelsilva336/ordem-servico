<?php

  include_once("dao/ClientDAO.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/OsDAO.php");





  class Rows {

    private $conn;
    private $url;

    

    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url; 
    }



    public function getRows($table, $dao){

        $classDao= new $dao($this->conn, $this->url);


        $stmt= $this->conn->query("SELECT * FROM $table");

        $stmt->execute();
        
        if($stmt->rowCount() > 0){

            return $stmt->rowCount();
      
        }else{
            return "0";
        }

    }

  }