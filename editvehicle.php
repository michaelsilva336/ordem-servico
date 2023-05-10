<?php 

  include_once("templates/header.php");
  include_once("dao/VehicleDAO.php");

  $vehicleDao= new VehicleDAO($conn, $BASE_URL);

  $id= filter_input(INPUT_GET, "id");


  if(empty($id)){

    $message->setMessage("O veículo não foi encontrado!", "error", "index.php");

  }else{

    $vehicleData= $vehicleDao->findById($id);

    if (!$vehicleData) {

        $message->setMessage("O veículo não foi encontrado!", "error", "index.php");
    }
  }
  

?>


<div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/vehicles.php?id=<?=$vehicleData->clients_id?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Editar Veículo</h1>
      <form action="<?= $BASE_URL ?>/vehicle_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="update">
        <input type="hidden" name="id-vehicle" value="<?=$vehicleData->id?>">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do veículo" value="<?=$vehicleData->name?>">
        </div>
        <div class="form-group">
          <label for="brand">Marca:</label>
          <input type="text" class="form-control" id="brand" name="brand" placeholder="Digite a marca do veículo" value="<?=$vehicleData->brand?>">
        </div>
        <div class="form-group">
          <label for="model">Modelo:</label>
          <input type="text" class="form-control" id="model" name="model" placeholder="Digite o modelo do veículo" value="<?=$vehicleData->model?>">
        </div>
        <div class="form-group">
          <label for="plate">Placa:</label>
          <input type="text" class="form-control" id="plate" name="plate" placeholder="Digite a placa do veículo" value="<?=$vehicleData->plate?>">
        </div>
        <input type="submit" class="btn card-btn" value="Editar Veículo">
      </form>
    </div>
  </div>

  

<?php 

  include_once("templates/footer.php");

?>