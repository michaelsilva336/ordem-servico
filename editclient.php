<?php 

  include_once("templates/header.php");
  include_once("models/Client.php");
  include_once("dao/ClientDAO.php");
  include_once("dao/UserDAO.php");

  $clientDao= new ClientDAO($conn, $BASE_URL);
  $userDao=  new UserDAO($conn, $BASE_URL);

  $userData= $userDao->verifyToken(true);

  $id= filter_input(INPUT_GET, "id");

  if(empty($id)){

    $message->setMessage("O cliente não foi encontrado!", "error", "login.php");

  }else{

    $client= $clientDao->findById($id);

    if (!$client) {

        $message->setMessage("O cliente não foi encontrado!", "error", "login.php");
    }
  }


?>



  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/clients.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Editar dados do Cliente</h1>
      <form action="<?= $BASE_URL ?>/client_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="update">
        <input type="hidden" name="id" value="<?=$client->id?>">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" value="<?=$client->name?>" >
        </div>
        <div class="form-group">
          <label for="cpf">CPF/CNPJ:</label>
          <input type="text" class="form-control" id="cpf" name="cpf" value=" <?= $client->cpf ?>">
        </div>
        <div class="form-group">
          <label for="phone">Telefone:</label>
          <input type="text" class="form-control" id="phone" name="phone" value=" <?= $client->phone ?>">
        </div>
        <div class="form-group">
          <label for="cell">Celular:</label>
          <input type="text" class="form-control" id="cell" name="cell" value=" <?= $client->cell ?>">
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" id="email" name="email" value=" <?= $client->email ?>">
        </div>
        <div class="form-group">
          <label for="rua">Rua:</label>
          <input type="text" class="form-control" id="rua" name="rua" value=" <?= $client->rua ?>">
        </div>
        <div class="form-group">
          <label for="number">N°:</label>
          <input type="text" class="form-control" id="number" name="number" value=" <?= $client->number ?>">
        </div>
        <div class="form-group">
          <label for="district">Bairro/Setor:</label>
          <input type="text" class="form-control" id="district" name="district" value=" <?= $client->district ?>">
        </div>
        <div class="form-group">
          <label for="city">Cidade:</label>
          <input type="text" class="form-control" id="city" name="city" value=" <?= $client->city ?>">
        </div>
        <div class="form-group">
          <label for="state">Estado:</label>
          <input type="text" class="form-control" id="state" name="state" value=" <?= $client->state ?>">
        </div>
        <div class="form-group">
          <label for="cep">Cep:</label>
          <input type="text" class="form-control" id="cep" name="cep" value=" <?= $client->cep ?>">
        </div>
        <input type="submit" class="btn card-btn" value="Editar Cliente">
      </form>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
