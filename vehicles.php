<?php 

  include_once("templates/header.php");
  include_once("dao/VehicleDAO.php");
  include_once("dao/ClientDAO.php");


  $vehicleDao= new VehicleDAO($conn, $BASE_URL);
  $clientDao= new ClientDAO($conn, $BASE_URL);

  $id= filter_input(INPUT_GET, "id");

  $vehicles= $vehicleDao->getVehicles();


  if(empty($id)){

    $message->setMessage("O cliente não foi encontrado!", "error", "login.php");

  }else{

    $clientData= $clientDao->findById($id);

    if (!$clientData) {

        $message->setMessage("O cliente não foi encontrado!", "error", "login.php");
    }
  }
 
?>

  <div class="container-fluid main-container">
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/clients.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <h2 class="section-title"> Veiculos do cliente <span id="vehicle-client-name"><?=$clientData->name?></span></h2>
    <div class="col-md-12" id="add-clients-container">
        <a href="<?= $BASE_URL ?>/newvehicle.php?id=<?=$clientData->id?>" id="btn-session"class="btn card-btn"><i class="fas fa-plus"></i> Adicionar veículo</a>
    </div>
    <div class="col-md-12" id="clients">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Modelo</th>
          <th scope="col">Placa</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody> 
          <?php foreach($vehicles as $vehicle): ?>
            <?php if($clientData->id === $vehicle->clients_id): ?>
              <tr>
                <td scope="row"> <?=$vehicle->id?> </td>
                <td><a href="<?= $BASE_URL ?>/viewvehicle.php?id=<?=$vehicle->id?>" class="table-clients-title"> <?=$vehicle->name?> </a></td>
                <td> <?=$vehicle->model?> </td>
                <td> <?=$vehicle->plate?> </td>
                <td class="actions-column">
                  <a href="<?= $BASE_URL ?>/editvehicle.php?id= <?=$vehicle->id?>" class="edit-btn">
                    <i class="far fa-edit"></i> Editar
                  </a>
                  <form action="<?= $BASE_URL ?>/vehicle_process.php" method="POST">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id-vehicle-delete" value="<?=$vehicle->id?>">
                    <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                  </form>
                </td>
              </tr>
            <?php endif;?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
