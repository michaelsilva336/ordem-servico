<?php 

  include_once("templates/header.php");
  include_once("dao/VehicleDAO.php");

  $vehicleDao= new VehicleDAO($conn, $BASE_URL);


  $id= filter_input(INPUT_GET, "id");

  if(!empty($id)){

    $vehicleData= $vehicleDao->findById($id);

    if($vehicleData){

        $vehicle= $vehicleData;

    }else{
        $message->setMessage("Veículo não encontrado", "error", "index.php");
    }

  }else{
    $message->setMessage("Veículo não encontrado", "error", "index.php");
  }


?>



  <div class="container-fluid table-view-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/vehicles.php?id=<?=$vehicleData->clients_id?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="col-12 table-view-container">
        <h1 id="view" class="title-table-view">Dados do Veículo</h1>
        <table id="table-view" class="table-bordered">
        <tbody>
            <tr>
            <td>Nome:</td>
            <td><?=$vehicle->name?></td>
            </tr>
            <tr>
            <td>Marca:</td>
            <td><?=$vehicle->brand?></td>
            </tr>
            <tr>
            <td>Modelo:</td>
            <td><?=$vehicle->model?></td>
            </tr>
            <tr>
            <td>Ano:</td>
            <td><?=$vehicle->year?></td>
            </tr>
            <tr>
            <td>Data de cadastro:</td>
            <td><?=$vehicle->date_entry?></td>
            </tr>
        </tbody>
        </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
