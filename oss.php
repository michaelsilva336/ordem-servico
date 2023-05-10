<?php 

  include_once("templates/header.php");
  include_once("dao/OsDAO.php");
  include_once("dao/ClientDAO.php");

  
  $osDao= new OsDAO($conn, $BASE_URL);
  $clientDao= new ClientDAO($conn, $BASE_URL);


  $query= filter_input(INPUT_GET, "query");

  $oss= $osDao->getOss();

  $clientsSeach= $clientDao->findByNameSearch($query);
  


 
?>

  <div class="container-fluid main-container">
    <div class="col-md-12" id="back-container">
      <div class="row">
          <div class="col-md-9">
            <a href="<?= $BASE_URL ?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
          </div>
          <div class="col-md-3">
            <form action="<?= $BASE_URL ?>/oss.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
              <input type="text" name="query" id="search" class="input-form" type="search" placeholder="Buscar Os " aria-label="Search">
              <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>
      </div>
    </div>
    <h2 class="section-title"> Ordens de Serviço</h2>
    <div class="col-md-12" id="add-clients-container">
        <a href="<?= $BASE_URL ?>/newos.php" id="btn-session"class="btn card-btn"><i class="fas fa-plus"></i> Adicionar Os</a>
    </div>
    <div class="col-md-12" id="clients">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Data de Entrada</th>
          <th scope="col">Status</th>
          <th scope="col">Veículo Placa</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody>




          <?php if(!empty($query)): ?>

            <?php foreach($clientsSeach as $clientsS): ?>

              <?php 
                $osDateResult= $osDao->findByIdClientSeach($clientsS->id);
              ?>

              <?php foreach($osDateResult as $osSeach): ?>

                <?php if($osSeach->status === "Finalizado"): ?>
                  <tr id="tr-end">
                    <td scope="row"> <?=$osSeach->id?> </td>
                    <td> <?=$clientsS->name?> </a></td>
                    <td id="date-finished"><a href="<?= $BASE_URL ?>/finalized.php?id= <?=$osSeach->id?>" target="_blank"><?=$osSeach->date_start?></a></td>
                    <td id= "status-end"> <?=$osSeach->status?> </td>
                    <td id= "status-end"> <?=$osSeach->vehicle_plate?> </td>
                    <td class="actions-column">
                      <form action="<?= $BASE_URL ?>/os_process.php" method="POST" id="form-delete-end">
                        <input type="hidden" name="type" value="delete">
                        <input type="hidden" name="id" value="<?=$osSeach->id?>">
                        <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                      </form>
                    </td>
                  </tr>
                <?php else: ?>
                  <tr>
                    <td scope="row"> <?=$osSeach->id?> </td>
                    <td><a href="<?= $BASE_URL ?>/finalized.php?id=<?=$osSeach->id?>" target="_blank" class="table-clients-title"> <?=$clientsS->name?> </a></td>
                    <td> <?=$osSeach->date_start?> </td>
                    <td> <?=$osSeach->status?> </td>
                    <td> <?=$osSeach->vehicle_plate?> </td>
                    <td class="actions-column">
                      <a href="<?= $BASE_URL ?>/editos.php?id= <?=$osSeach->id?> " class="edit-btn">
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <form action="<?= $BASE_URL ?>/os_process.php" method="POST">
                        <input type="hidden" name="type" value="delete">
                        <input type="hidden" name="id" value="<?=$osSeach->id?>">
                        <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                      </form>
                    </td>
                  </tr>
                <?php endif;?>
              <?php endforeach; ?>
              
            <?php endforeach; ?>

            <?php $query= "";?>

          <?php else: ?>

            <?php foreach($oss as $os): ?>

              <?php $clientData= $clientDao->findById($os->clients_id);
                  $os->client_name= $clientData->name;
              ?>

              <?php if($os->status === "Finalizado"): ?>
                  <tr id="tr-end">
                    <td scope="row"> <?=$os->id?> </td>
                    <td> <?=$os->client_name?> </a></td>
                    <td id="date-finished"><a href="<?= $BASE_URL ?>/finalized.php?id= <?=$os->id?>" target="_blank"><?=$os->date_start?></a></td>
                    <td id= "status-end"> <?=$os->status?> </td>
                    <td id= "status-end"> <?=$os->vehicle_plate?> </td>
                    <td class="actions-column">
                      <form action="<?= $BASE_URL ?>/os_process.php" method="POST" id="form-delete-end">
                        <input type="hidden" name="type" value="delete">
                        <input type="hidden" name="id" value="<?=$os->id?>">
                        <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                      </form>
                    </td>
                  </tr>
              <?php else: ?>
                <tr>
                  <td scope="row"> <?=$os->id?> </td>
                  <td><a href="<?= $BASE_URL ?>/finalized.php?id=<?=$os->id?>" target="_blank" class="table-clients-title"> <?=$os->client_name?> </a></td>
                  <td> <?=$os->date_start?> </td>
                  <td> <?=$os->status?> </td>
                  <td> <?=$os->vehicle_plate?> </td>
                  <td class="actions-column">
                    <a href="<?= $BASE_URL ?>/editos.php?id= <?=$os->id?> " class="edit-btn">
                      <i class="far fa-edit"></i> Editar
                    </a>
                    <form action="<?= $BASE_URL ?>/os_process.php" method="POST">
                      <input type="hidden" name="type" value="delete">
                      <input type="hidden" name="id" value="<?=$os->id?>">
                      <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                    </form>
                  </td>
                </tr>
              <?php endif;?>
            <?php endforeach; ?>

          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
