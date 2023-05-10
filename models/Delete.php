<?php

  include_once("models/Message.php");


  class Delete {

    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }



    
    public function destroy($id, $table, $msg){

        $stmt= $this->conn->prepare("DELETE FROM $table WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $this->message->setMessage($msg, "success", "back");
        }

    }

  }