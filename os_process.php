<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Client.php");
  require_once("models/Os.php");
  require_once("models/Message.php");
  require_once("models/Delete.php");
  require_once("models/Complete.php");
  require_once("models/ProductOs.php");
  require_once("models/ServiceOs.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ClientDAO.php");
  require_once("dao/OsDAO.php");
  require_once("dao/ProductDAO.php");
  require_once("dao/ServiceDAO.php");
  require_once("dao/ProductOsDAO.php");
  require_once("dao/ServiceOsDAO.php");


  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $clientDao = new ClientDAO($conn, $BASE_URL);
  $osDao = new OsDAO($conn, $BASE_URL);
  $productDao = new ProductDAO($conn, $BASE_URL);
  $serviceDao = new ServiceDAO($conn, $BASE_URL);
  $productOsDao = new ProductOsDAO($conn, $BASE_URL);
  $serviceOsDao = new ServiceOsDAO($conn, $BASE_URL);
  $delete = new Delete($conn, $BASE_URL);
  $complete = new Complete($conn, $BASE_URL);



  $userData = $userDao->verifyToken(true);




  $type= filter_input(INPUT_POST, "type");



  
  if($type === "create"){

    $clientName= filter_input(INPUT_POST, "clientName");
    $responsible= filter_input(INPUT_POST, "responsible");
    $status= filter_input(INPUT_POST, "status");
    $date_start= filter_input(INPUT_POST, "date_start");
    $date_end= filter_input(INPUT_POST, "date_end");
    $warranty= filter_input(INPUT_POST, "warranty");
    $defect= filter_input(INPUT_POST, "defect");
    $observation= filter_input(INPUT_POST, "observation");

    $clientData= $clientDao->findByName($clientName);
    $clients_id= $clientData->id;
  
    $users_id= $userData->id;

    if(!empty($clientName) && !empty($status) && !empty($date_start)){
        
        $os= new Os();
      
        $os->responsible= $responsible;
        $os->status= $status;
        $os->date_start= $date_start;
        $os->date_end= $date_end;
        $os->warranty= $warranty;
        $os->defect= $defect;
        $os->observation= $observation;
        $os->clients_id= $clients_id;
        $os->users_id= $users_id;

        $osDao->create($os);

    }else{
      $message->setMessage("Preenche os campos Nome do cliente, Status, Data inicial!", "error", "back");
    }
  




  }else if($type === "update"){

    $clientName= filter_input(INPUT_POST, "clientName");
    $responsible= filter_input(INPUT_POST, "responsible");
    $status= filter_input(INPUT_POST, "status");
    $date_start= filter_input(INPUT_POST, "date_start");
    $date_end= filter_input(INPUT_POST, "date_end");
    $warranty= filter_input(INPUT_POST, "warranty");
    $defect= filter_input(INPUT_POST, "defect");
    $observation= filter_input(INPUT_POST, "observation");
    $id= filter_input(INPUT_POST, "id");
    $arrayDown= filter_input(INPUT_POST, "array-down");

    print_r($arrayDown);


    //Verifica novamente o id
    $osData= $osDao->findById($id);

    if($osData){
      
      if(!empty($status) && !empty($date_start) && !empty($defect)){

        $osData->responsible= $responsible;
        $osData->status= $status;
        $osData->date_start= $date_start;
        $osData->date_end= $date_end;
        $osData->warranty= $warranty;
        $osData->defect= $defect;
        $osData->observation= $observation;
        $osData->id= $id;

        $osDao->update($osData, true, "back");

      }else{
        $message->setMessage("Preencher os campos Status, Data inicial, Descrição do produto, Defeito e Data Final!", "error", "back");
      }

    }else{
      $message->setMessage("Os não encontrada!", "error", "index.php");
    }






  }else if($type === "delete"){  

    $id= filter_input(INPUT_POST, "id");

    $os= $osDao->findById($id);

    if($os){

      $delete->destroy($os->id, "services_orders", "Os excluida com sucesso!");

    }else{
      $message->setMessage("Os não encontrada", "error", "index.php");
    }

  
  



  }else if($type === "create-product-os"){

    $productName= filter_input(INPUT_POST, "productName");
    $amount= filter_input(INPUT_POST, "amount");
    $id_os= filter_input(INPUT_POST, "id-os");

    $productData= $productDao->findByName($productName);
    $product_id= $productData->id;
    $product_value_buy= $productData->value_buy;


    if(!empty($amount) && !empty($productName)){

      $productOs= new ProductOs();

      $sum= $productOs->sum($product_value_buy, $amount);

      $productOs->amount= $amount;
      $productOs->sub_total= $sum;
      $productOs->services_orders_id= $id_os;
      $productOs->porcent= 0;
      $productOs->porcent_price_sum= 0;
      $productOs->porcent_value_total= 0;
      $productOs->products_id= $product_id; 

      $productOsDao->create($productOs);


    }else{
      $message->setMessage("Necessário preencher o campo serviço e quantidade!", "error", "back");
    }




  }else if($type === "delete-product-os"){

    $id_product_os= filter_input(INPUT_POST, "id-product-os");

    $productOs= $productOsDao->findById($id_product_os);

    if($productOs){

      $delete->destroy($productOs->id, "products_os", "Produto excluido com sucesso!");

    }else{
      $message->setMessage("Produto não encontrado", "error", "index.php");
    }
    





  }else if($type === "create-service-os"){


    $serviceName= filter_input(INPUT_POST, "serviceName");
    $id_os= filter_input(INPUT_POST, "id-os");

    $serviceData= $serviceDao->findByName($serviceName);

    $service_id= $serviceData->id;
    $sub_total= $serviceData->value;


    if(!empty($serviceName)){

      $serviceOs= new ServiceOs();

      $serviceOs->services_orders_id= $id_os;
      $serviceOs->sub_total= $sub_total;
      $serviceOs->services_id= $service_id; 

      $serviceOsDao->create($serviceOs);


    }else{
      $message->setMessage("Necessário preencher o serviço!", "error", "back");
    }




  }else if($type === "delete-service-os"){

    $id_service_os= filter_input(INPUT_POST, "id-service-os");

    $serviceOs= $serviceOsDao->findById($id_service_os);

    if($serviceOs){

      $delete->destroy($serviceOs->id, "services_os", "Serviço excluido com sucesso!");

    }else{
      $message->setMessage("Serviço não encontrado", "error", "index.php");
    }




  }else if($type === "add-porcent" ){

    $id_os_porcent= filter_input(INPUT_POST, "id_os");
    $porcent_value= filter_input(INPUT_POST, "porcent");
    $page= filter_input(INPUT_POST, "Page");


    if($porcent_value >= 0){

      $productOsDao->updatePorcent($porcent_value, $id_os_porcent, $page);
    
    }



  }else{
    $message->setMessage("Informações inválidas", "error", "index.php");
  }








    
   


 