<?php 

  include_once("templates/header.php");

?>



  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/clients.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Adicionar Cliente</h1>
      <form action="<?= $BASE_URL ?>/client_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome">
        </div>
        <div class="form-group">
          <label for="cpf">CPF/CNPJ:</label>
          <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF/CNPJ">
        </div>
        <div class="form-group">
          <label for="phone">Telefone:</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Digite o telefone com DDD">
        </div>
        <div class="form-group">
          <label for="cell">Celular:</label>
          <input type="text" class="form-control" id="cell" name="cell" placeholder="Digite o número celular com DDD">
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Digite o email">
        </div>
        <div class="form-group">
          <label for="rua">Rua:</label>
          <input type="text" class="form-control" id="rua" name="rua" placeholder="Digite o nome da rua">
        </div>
        <div class="form-group">
          <label for="number">N°:</label>
          <input type="text" class="form-control" id="number" name="number" placeholder="Digite o numero do endereço">
        </div>
        <div class="form-group">
          <label for="district">Bairro/Setor:</label>
          <input type="text" class="form-control" id="district" name="district" placeholder="Digite o Bairro">
        </div>
        <div class="form-group">
          <label for="city">Cidade:</label>
          <input type="text" class="form-control" id="city" name="city" placeholder="Digite a cidade">
        </div>
        <div class="form-group">
          <label for="state">Estado:</label>
          <input type="text" class="form-control" id="state" name="state" placeholder="Digite o estado">
        </div>
        <div class="form-group">
          <label for="cep">Cep:</label>
          <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o cep da rua">
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar Cliente">
      </form>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
