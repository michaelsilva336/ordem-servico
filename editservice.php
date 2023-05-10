<?php 

  include_once("templates/header.php");
  include_once("models/Service.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/UserDAO.php");

  $serviceDao= new ServiceDAO($conn, $BASE_URL);
  $userDao=  new UserDAO($conn, $BASE_URL);

  $userData= $userDao->verifyToken(true);

  $id= filter_input(INPUT_GET, "id");

  if(empty($id)){

    $message->setMessage("O serviço não foi encontrado!", "error", "login.php");

  }else{

    $service= $serviceDao->findById($id);

    if (!$service) {

        $message->setMessage("O serviço não foi encontrado!", "error", "login.php");
    }
  }

?>
 
  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/services.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Editar Serviço</h1>
      <form action="<?= $BASE_URL ?>/service_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="update">
        <input type="hidden" name="id" value="<?=$service->id?>">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do serviço" value="<?=$service->name?>">
        </div>
        <div class="form-group">
          <label for="value">Valor:</label>
          <input type="text" class="form-control" id="value" name="value" placeholder="Digite o valor do serviço" value="<?=$service->value?>">
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o serviço..."><?=$service->description?></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Editar Serviço">
      </form>
    </div>
  </div>    

<?php 

  include_once("templates/footer.php");

?>
