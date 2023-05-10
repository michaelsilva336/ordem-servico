<?php 

  include_once("templates/header.php");
  include_once("dao/UserDAO.php");
  include_once("dao/OsDAO.php");
  include_once("dao/ProductOsDAO.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/ServiceOsDAO.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/VehicleDAO.php");
 

  

  $userDao=  new UserDAO($conn, $BASE_URL);
  $osDao= new OsDAO($conn, $BASE_URL);
  $productOsDao= new ProductOsDAO($conn, $BASE_URL);
  $productDao= new ProductDAO($conn, $BASE_URL);
  $serviceOsDao= new ServiceOsDAO($conn, $BASE_URL);
  $serviceDao= new ServiceDAO($conn, $BASE_URL);
  $vehicleDao= new VehicleDAO($conn, $BASE_URL);
 


  $userData= $userDao->verifyToken(true);

  $id_os= filter_input(INPUT_GET, "id");

  if(empty($id_os)){

    $message->setMessage("Os não foi encontrado!", "error", "login.php");

  }else{

    $os= $osDao->findById($id_os);

    if (!$os) {

        $message->setMessage("Os não foi encontrado!", "error", "login.php");
    }
  }

  $products_os= $productOsDao->getProductsOs();
  $porcent= $productOsDao->findByOs($os->id);
  
  $services_os= $serviceOsDao->getServicesOs();

  $vehicles= $vehicleDao->getVehicles();

  if($porcent == NULL){
    $porcent[2]= 0;
  }

 

  $value_pro= 0;
  $value_ser= 0;

  $value_porcent= 0;

  //target="_blank"
 
?>



  <div class="container" id="container-view-os">


    <div class="row" id="container-tree-btn-finalized">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4" id="btn-orcamento">
            <a href="<?= $BASE_URL ?>/relacaoprint.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Relação Peças</a>
          </div>
          <div class="col-md-4" id="btn-view">
            <a href="<?= $BASE_URL ?>/orcamentoprint.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Orçamento Peças</a>
          </div>
          <div class="col-md-4" id="btn-view">
            <a href="<?= $BASE_URL ?>/osprint.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Ordem de Serviço</a>
          </div>
        </div>
      </div>
    </div>
    

  </div>

<?php 

  include_once("templates/footer.php");

?>