<?php 

  include_once("templates/header.php");
  include_once("dao/ServiceDAO.php");
  
  $serviceDao= new ServiceDAO($conn, $BASE_URL);

  $query= filter_input(INPUT_GET, "query");

  $services= $serviceDao->getServices();

  $serviceSeach= $serviceDao->findByNameSearch($query);

 
?>

  <div class="container-fluid main-container">
    <div class="col-md-12" id="back-container">
      <div class="row">
            <div class="col-md-9">
              <a href="<?= $BASE_URL ?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
            </div>
            <div class="col-md-3">
              <form action="<?= $BASE_URL ?>/services.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="query" id="search" class="input-form" type="search" placeholder="Buscar Serviços " aria-label="Search">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
        </div>
      </div>
    <h2 class="section-title"> Serviços</h2>
    <div class="col-md-12" id="add-clients-container">
        <a href="<?= $BASE_URL ?>/newservice.php" id="btn-session"class="btn card-btn"><i class="fas fa-plus"></i> Adicionar Serviço</a>
    </div>
    <div class="col-md-12" id="clients">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Nome do Serviço</th>
          <th scope="col">Valor</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody> 
          
          <?php if(!empty($query)): ?>

            <?php foreach($serviceSeach as $serviceS): ?>

              <tr>
                <td scope="row"> <?=$serviceS->id?> </td>
                <td><a href="<?= $BASE_URL ?>/viewservice.php?id=<?=$serviceS->id?>" class="table-clients-title"> <?=$serviceS->name?> </a></td>
                <td> <?="R$" . $numb= number_format($serviceS->value, 2, ',', '.')?> </td>
                <td class="actions-column">
                  <a href="<?= $BASE_URL ?>/editservice.php?id= <?=$serviceS->id?> " class="edit-btn">
                    <i class="far fa-edit"></i> Editar
                  </a>
                  <form action="<?= $BASE_URL ?>/service_process.php" method="POST">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="<?=$serviceS->id?>">
                    <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                  </form>
                </td>
              </tr>

            <?php endforeach; ?>

            <?php $query= "";?>

            <?php else: ?>

            <?php foreach($services as $service): ?>
              <tr>
                <td scope="row"> <?=$service->id?> </td>
                <td><a href="<?= $BASE_URL ?>/viewservice.php?id=<?=$service->id?>" class="table-clients-title"> <?=$service->name?> </a></td>
                <td> <?="R$" . $numb= number_format($service->value, 2, ',', '.')?> </td>
                <td class="actions-column">
                  <a href="<?= $BASE_URL ?>/editservice.php?id= <?=$service->id?> " class="edit-btn">
                    <i class="far fa-edit"></i> Editar
                  </a>
                  <form action="<?= $BASE_URL ?>/service_process.php" method="POST">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="<?=$service->id?>">
                    <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>

            <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
