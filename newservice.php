<?php 

  include_once("templates/header.php");

?>

  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/services.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Adicionar Serviço</h1>
      <form action="<?= $BASE_URL ?>/service_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do serviço">
        </div>
        <div class="form-group">
          <label for="value">Valor:</label>
          <input type="text" class="form-control" id="value" name="value" placeholder="Digite o valor do serviço">
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o serviço..."></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar Serviço">
      </form>
    </div>
  </div>    

<?php 

  include_once("templates/footer.php");

?>
