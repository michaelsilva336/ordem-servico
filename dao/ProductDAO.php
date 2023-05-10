<?php

  include_once("models/Product.php");
  include_once("models/User.php");
  include_once("models/Message.php");
  include_once("dao/UserDAO.php");
  include_once("dao/ProductOsDAO.php");
  



  class ProductDAO implements ProductDAOInterface {


    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }




    public function bildProduct($data){

        $product= new Product();

        $product->id= $data["id"];
        $product->name= $data["name"];
        $product->brand= $data["brand"];
        $product->unity= $data["unity"];
        $product->value_buy= $data["value_buy"];
        $product->value_sale= $data["value_sale"]; 
        $product->amount= $data["amount"];  
        $product->inventory= $data["inventory"];
        $product->barcode= $data["barcode"];
        $product->entry_date= $data["entry_date"];
        $product->users_id= $data["users_id"];
        
       
        return $product;

    }


    public function create(Product $product){

        $stmt= $this->conn->prepare("INSERT INTO products (name, brand, unity, value_buy, users_id) VALUES (:name, :brand, :unity, :value_buy, :users_id)");


        $stmt->bindParam(":name", $product->name);
        $stmt->bindParam(":brand", $product->brand);
        $stmt->bindParam(":unity", $product->unity);
        $stmt->bindParam(":value_buy", $product->value_buy);    
        //$stmt->bindParam(":value_sale", $product->value_sale);
        //$stmt->bindParam(":amount", $product->amount);
        //$stmt->bindParam(":inventory", $product->inventory);
        //$stmt->bindParam(":barcode", $product->barcode);
        $stmt->bindParam(":users_id", $product->users_id);
        
        $stmt->execute();

        $this->message->setMessage("Produto adicionado com sucesso!", "success", "products.php");

    }



    public function update(Product $product, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE products SET name= :name, brand= :brand, unity= :unity, value_buy= :value_buy WHERE id= :id");

        $stmt->bindParam(":name", $product->name);
        $stmt->bindParam(":brand", $product->brand);
        $stmt->bindParam(":unity", $product->unity);
        $stmt->bindParam(":value_buy", $product->value_buy);
        //$stmt->bindParam(":value_sale", $product->value_sale);
        //$stmt->bindParam(":amount", $product->amount);
        //$stmt->bindParam(":inventory", $product->inventory);
        //$stmt->bindParam(":barcode", $product->barcode);
        $stmt->bindParam(":id", $product->id);

        $stmt->execute();


        if($redirect){

            $this->message->setMessage("Produto editado com sucesso!", "success", "products.php");
        }
        
    }


    public function getProducts(){

        $products= [];

        $stmt= $this->conn->query("SELECT * FROM products ORDER BY name");

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $array= $stmt->fetchALL();

            foreach($array as $product){
                $products[]= $this->bildProduct($product);
            }

        }

        return $products;

    }



    public function findById($id){

        $userDao= new UserDAO($this->conn, $this->url);


        $stmt= $this->conn->prepare("SELECT * FROM products WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $product= $this->bildProduct($array);
            $userData= $userDao->findById($product->users_id);

            $product->user_name= $userData->user;

            return $product;

        }else{
            return false;
        }

   }


   public function findByName($name){

        $stmt= $this->conn->prepare("SELECT * FROM products WHERE name= :name");

        $stmt->bindParam(":name", $name);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data= $stmt->fetch();

            $product= $this->bildProduct($data);

            return $product;

        }else{
            return false;
        }

   }


   public function findByBarcode($barcode){

        $stmt= $this->conn->prepare("SELECT * FROM products WHERE barcode= :barcode");

        $stmt->bindParam(":barcode", $barcode);

        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data= $stmt->fetch();

            $product= $this->bildProduct($data);

            return $product;

        }else{
            return false;
        }


   }


   public function findByNameSearch($name){
      
    $names= [];

    $stmt= $this->conn->prepare("SELECT * FROM products WHERE name LIKE :name");

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

}

