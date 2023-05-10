<?php 

  include_once("templates/header.php");
  include_once("dao/ClientDAO.php");
  
  $clientDao= new ClientDAO($conn, $BASE_URL);

  $query= filter_input(INPUT_GET, "query");

  $clients= $clientDao->getClients();

  $clientsSeach= $clientDao->findByNameSearch($query);

 
?>

  <div class="container-fluid main-container">
    <div class="col-md-12" id="back-container">
      <div class="row">
        <div class="col-md-9">
          <a href="<?= $BASE_URL ?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>
        <div class="col-md-3">
          <form action="<?= $BASE_URL ?>/clients.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
            <input type="text" name="query" id="search" class="input-form" type="search" placeholder="Buscar Cliente" aria-label="Search">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </form>
        </div>
      </div>  
    </div>
    <h2 class="section-title"> Clientes</h2>
    <div class="col-md-12" id="add-clients-container">
        <a href="<?= $BASE_URL ?>/newclient.php" id="btn-session"class="btn card-btn"><i class="fas fa-plus"></i> Adicionar Cliente</a>
    </div>
    <div class="col-md-12" id="clients">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Nome do Cliente</th>
          <th scope="col">CPF/CNPJ</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody>
        
            <?php if(!empty($query)): ?>

              <?php foreach($clientsSeach as $clientS): ?>

                <tr>
                  <td scope="row"> <?=$clientS->id?> </td>
                  <td><a href="<?= $BASE_URL ?>/viewclient.php?id=<?=$clientS->id?>" class="table-clients-title"> <?=$clientS->name?> </a></td>
                  <td> <?=$clientS->cpf?> </td>

                  <td class="actions-column">
                    <a id="btn-vehicles"href="<?= $BASE_URL ?>/vehicles.php?id= <?=$clientS->id?>" class="edit-btn">
                      <i class="fa fa-car"></i>
                    </a>
                    <a href="<?= $BASE_URL ?>/editclient.php?id= <?=$clientS->id?>" class="edit-btn">
                      <i class="far fa-edit"></i> Editar
                    </a>
                    <form action="<?= $BASE_URL ?>/client_process.php" method="POST">
                      <input type="hidden" name="type" value="delete">
                      <input type="hidden" name="id" value="<?=$clientS->id?>">
                      <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                    </form>
                  </td>
                </tr>

              <?php endforeach; ?>

              <?php $query= "";?>

            <?php else: ?>

              <?php foreach($clients as $client): ?>
                <tr>
                  <td scope="row"> <?=$client->id?> </td>
                  <td><a href="<?= $BASE_URL ?>/viewclient.php?id=<?=$client->id?>" class="table-clients-title"> <?=$client->name?> </a></td>
                  <td> <?=$client->cpf?> </td>

                  <td class="actions-column">
                    <a id="btn-vehicles"href="<?= $BASE_URL ?>/vehicles.php?id= <?=$client->id?>" class="edit-btn">
                      <i class="fa fa-car"></i>
                    </a>
                    <a href="<?= $BASE_URL ?>/editclient.php?id= <?=$client->id?>" class="edit-btn">
                      <i class="far fa-edit"></i> Editar
                    </a>
                    <form action="<?= $BASE_URL ?>/client_process.php" method="POST">
                      <input type="hidden" name="type" value="delete">
                      <input type="hidden" name="id" value="<?=$client->id?>">
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