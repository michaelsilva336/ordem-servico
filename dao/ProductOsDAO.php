<?php

  include_once("models/ProductOs.php");
  include_once("models/Message.php");
  include_once("models/Delete.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/OsDAO.php");



  class ProductOsDAO implements ProductOsInterface {

    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }



    public function bildProductOs($data){

        $productOs= new ProductOs();

        $productOs->id= $data["id"];
        $productOs->amount= $data["amount"];
        $productOs->sub_total= $data["sub_total"];
        $productOs->porcent= $data["porcent"];
        $productOs->porcent_price_sum= $data["porcent_price_sum"];
        $productOs->porcent_value_total= $data["porcent_value_total"];
        $productOs->services_orders_id= $data["services_orders_id"];
        $productOs->products_id= $data["products_id"];

        return $productOs;
    }



    public function create(ProductOs $productOs){

        $stmt= $this->conn->prepare("INSERT INTO products_os (amount, sub_total, porcent, porcent_price_sum, porcent_value_total, services_orders_id, products_id) VALUES (:amount, :sub_total, :porcent, :porcent_price_sum, :porcent_value_total, :services_orders_id, :products_id)");

        $stmt->bindParam(":amount", $productOs->amount);
        $stmt->bindParam(":sub_total", $productOs->sub_total);
        $stmt->bindParam(":porcent", $productOs->porcent);
        $stmt->bindParam(":porcent_price_sum", $productOs->porcent_price_sum);
        $stmt->bindParam(":porcent_value_total", $productOs->porcent_value_total);
        $stmt->bindParam(":services_orders_id", $productOs->services_orders_id);    
        $stmt->bindParam(":products_id", $productOs->products_id);

        $stmt->execute();

        $this->message->setMessage("", "", "back");
        
    }



    public function update(ProductOs $product_os, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE products_os SET porcent= :porcent, porcent_price_sum= :porcent_price_sum, porcent_value_total= :porcent_value_total  WHERE id= :id");

        $stmt->bindParam(":porcent", $product_os->porcent_number);
        $stmt->bindParam(":porcent_price_sum", $product_os->result_price);
        $stmt->bindParam(":porcent_value_total", $product_os->result_total_porcent);
        $stmt->bindParam(":id", $product_os->id);

        $stmt->execute();
        
        if($redirect){

            $this->message->setMessage("Porcentagem Adicionada!", "success", "viewos.php?id=" . $product_os->id_os);
        }
        
    }




    public function updatePorcent($porcent, $id_os, $page){

        $stmt= $this->conn->prepare("UPDATE products_os SET porcent= :porcent WHERE services_orders_id= :id_os");

        $stmt->bindParam(":porcent", $porcent);
        $stmt->bindParam(":id_os", $id_os);

        $stmt->execute();
        
        if($page === "orcamento"){

            header("Location: $this->url/" . "orcamento.php?id=" . $id_os);
            
        }else{
            header("Location: $this->url/" . "viewos.php?id=" . $id_os);
        }
        
    }




    public function getProductsOs(){

        //$osDao= new OsDAO($this->conn, $this->url);
        //$productDao= new ProductDAO($this->conn, $this->url);

        $productOs= [];

        $stmt= $this->conn->query("SELECT * FROM products_os");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $product){
                $productOs[]= $this->bildProductOs($product);

                //$osData= $osDao->findById($productOs->services_orders_id);

            }
        }

        return $productOs;



    }

    public function findById($id){

        $stmt= $this->conn->prepare("SELECT * FROM products_os WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $productOs= $this->bildProductOs($array);

            return $productOs;

        }else{
            return false;
        }

    }

    

    public function findByOs($id_os){

        $arrayDown= [];

        $stmt= $this->conn->prepare("SELECT * FROM products_os WHERE services_orders_id= :services_orders_id");

        $stmt->bindParam(":services_orders_id", $id_os);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchAll();

            foreach($array as $productOs){

                $resut= $this->bildProductOs($productOs);

                $arrayDown[]= $resut->products_id;
                $arrayDown[]= $resut->amount;
                $arrayDown[]= $resut->porcent;

            }

        }else{

            
        }

        return $arrayDown;
        
    }


    public function findByProduct($id_product){

        $stmt= $this->conn->prepare("SELECT * FROM products_os WHERE products_id= :products_id");

        $stmt->bindParam(":products_id", $id_product);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetch();

            $productOs= $this->bildProductOs($array);

            return $productOs;
        }

        
    }






    public function inventoryDown($id_os){

        $osDao= new OsDAO($this->conn, $this->url);
        $osData= $osDao->findById($id_os);

        $array= $this->findByOs($osData->id);

        if(empty($array)){

            $osData->billed= "true";
            $osDao->update($osData, false, "back");

        }else{

            for ($i=0; $i < count($array) ; $i++) {

                if($i % 2 == 0){
    
                    $productDao= new ProductDAO($this->conn, $this->url);
                    $productData= $productDao->findById($array[$i]);
                }
    
                if($i % 2 == 1){
    
                    $productData->inventory -= $array[$i];
    
                    $productDao->update($productData, false);
    
                    $osData->billed= "true";
                    $osDao->update($osData, false, "back");
    
                }
      
            }
        }

    }


    public function inventorySum($id_os){

        $osDao= new OsDAO($this->conn, $this->url);
        $osData= $osDao->findById($id_os);

        $array= $this->findByOs($osData->id);

        if(empty($array)){

            $osData->billed= "";
            $osDao->update($osData, false, "back");

        }else{

            for ($i=0; $i < count($array); $i++) {

                if($i % 2 == 0){
    
                    $productDao= new ProductDAO($this->conn, $this->url);
                    $productData= $productDao->findById($array[$i]);
                }
    
                if($i % 2 == 1){
    
                    $productData->inventory += $array[$i];
                    $productDao->update($productData, false);
    
                    $osData->billed= "";
                    $osDao->update($osData, false, "back");
    
                }
                
            }

        }

    }

  }