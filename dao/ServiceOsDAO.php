<?php

  include_once("models/ServiceOs.php");
  include_once("models/Message.php");
  include_once("models/Delete.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/OsDAO.php");



  class ServiceOsDAO implements ServiceOsInterface {

    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }




    public function bildServiceOs($data){

        $serviceOs= new serviceOs();

        $serviceOs->id= $data["id"];
        $serviceOs->sub_total= $data["sub_total"];
        $serviceOs->services_orders_id= $data["services_orders_id"];
        $serviceOs->services_id= $data["services_id"];

        return $serviceOs;

    }
    public function create(ServiceOs $serviceOs){

        $stmt= $this->conn->prepare("INSERT INTO services_os (sub_total, services_orders_id, services_id) VALUES (:sub_total, :services_orders_id, :services_id)");

        $stmt->bindParam(":sub_total", $serviceOs->sub_total);
        $stmt->bindParam(":services_orders_id", $serviceOs->services_orders_id);    
        $stmt->bindParam(":services_id", $serviceOs->services_id);

        $stmt->execute();

        $this->message->setMessage("", "", "back");



    }
    
    public function getServicesOs(){

        $serviceDao= new ServiceDAO($this->conn, $this->url);

        $serviceOs= [];

        $stmt= $this->conn->query("SELECT * FROM services_os");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $service){
                $serviceOs[]= $this->bildServiceOs($service);
            }
        }

        return $serviceOs;

    }



    public function findById($id){

        $stmt= $this->conn->prepare("SELECT * FROM services_os WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $serviceOs= $this->bildServiceOs($array);

            return $serviceOs;

        }else{
            return false;
        }

    }
}