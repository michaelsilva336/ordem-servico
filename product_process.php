<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Product.php");
  require_once("models/Message.php");
  require_once("models/Delete.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ProductDAO.php");
  

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $productDao = new ProductDAO($conn, $BASE_URL);
  $delete = new Delete($conn, $BASE_URL);


  $type = filter_input(INPUT_POST, "type");


  $userData = $userDao->verifyToken(true);


  if($type === "create"){

    $name= filter_input(INPUT_POST, "name");
    $brand= filter_input(INPUT_POST, "brand");
    $unity= filter_input(INPUT_POST, "unity");
    $value_buy= filter_input(INPUT_POST, "value_buy");
    //$value_sale= filter_input(INPUT_POST, "value_sale");
    //$amount= filter_input(INPUT_POST, "amount");
    //$barcode= filter_input(INPUT_POST, "barcode");
    $users_id= $userData->id;

    $product= new Product();

  
    
    //$findBarcode = $productDao->findByBarcode($barcode);


    //if(!$findBarcode){

      if(!empty($name) && !empty($unity)){

        
        $product->name= $name;
        $product->brand= $brand;
        $product->unity= $unity;
        $product->value_buy= $value_buy;
        //$product->value_sale= $value_sale;
        //$product->amount= $amount;
        //$product->inventory= $amount;
        //$product->barcode= $barcode;
        $product->users_id= $users_id;

        $productDao->create($product);

      }else{
          $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
      }

    //else{
      //$message->setMessage("Produto já cadastrado! Adicione a quantidade adquirida no estoque.", "error", "viewproduct.php?id=" . $findBarcode->id);

    //}



  
  }else if($type === "update"){


    $name= filter_input(INPUT_POST, "name");
    $brand= filter_input(INPUT_POST, "brand");
    $unity= filter_input(INPUT_POST, "unity");
    $value_buy= filter_input(INPUT_POST, "value_buy");
    //$value_sale= filter_input(INPUT_POST, "value_sale");
    //$amount= filter_input(INPUT_POST, "amount");
    //$inventory= filter_input(INPUT_POST, "inventory");
    //$barcode= filter_input(INPUT_POST, "barcode");
    $id= filter_input(INPUT_POST, "id");

    //Verifica novamente o id
    $productData= $productDao->findById($id);

    if ($productData) {

      if(!empty($name) && !empty($unity)){

        $productData->name= $name;
        $productData->brand= $brand;
        $productData->unity= $unity;
        $productData->value_buy= $value_buy;
        //$productData->value_sale= $value_sale;
        //$productData->amount= $amount;
        //$productData->inventory= $inventory;
        //$productData->barcode= $barcode;
        $productData->id= $id;

  
        $productDao->update($productData, true);
        

      }else{
        $message->setMessage("É necessário preencher todos os campos do formulário!", "error", "back");
      }

    }else{
      $message->setMessage("Produto não encontrado", "error", "login.php");
    }




  }else if($type === "add-stock"){

    $id_pro= filter_input(INPUT_POST, "id-pro");
    $amount= filter_input(INPUT_POST, "amount");

    $product_stock= $productDao->findById($id_pro);

    if($product_stock){

      if(!empty($amount)){

        $product_stock->inventory += $amount;

        $productDao->update($product_stock, false);

        $message->setMessage("Estoque atualizado!", "error", "back");

      }else{
        $message->setMessage("Necessário adicionar a quantidade!", "error", "back");
      }

    }else{
      $message->setMessage("Produto não encontrado", "error", "index.php");
    }




  
  }else if($type === "delete"){

    
    $id= filter_input(INPUT_POST, "id");

    $product= $productDao->findById($id);

    if($product){

      $delete->destroy($product->id, "products", "Produto excluido com sucesso!");

    }else{
      $message->setMessage("Informações inválidas!", "error", "login.php");
    }
  

  }else{
    $message->setMessage("Informações inválidas!", "error", "index.php");
  }