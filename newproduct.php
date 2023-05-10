<?php 

  include_once("templates/header.php");

?>



  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/products.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Adicionar Produto</h1>
      <form action="<?= $BASE_URL ?>/product_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do produto">
        </div>
        <div class="form-group">
          <label for="brand">Marca:</label>
          <input type="text" class="form-control" id="brand" name="brand" placeholder="Digite a marca do produto">
        </div>
        
        <div class="form-group">
          <label for="unity">Unidade:</label>
          <select name="unity" id="unity" class="form-control">
              <option value="">Selecione</option>
              <option value="CX">CX</option>
              <option value="JG">JG</option>
              <option value="PC">PC</option>
              <option value="LT">LT</option>
              <option value="UN">UN</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="value_buy">Valor Compra:</label>
          <input type="text" class="form-control" id="value_buy" name="value_buy" placeholder="Digite o valor de compra">
        </div>
        <!--<div class="form-group">
          <label for="value_sale">Valor Venda:</label>
          <input type="text" class="form-control" id="value_sale" name="value_sale" placeholder="Digite o valor de venda">
        </div>
        <div class="form-group">
          <label for="amount">Quantidade:</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Digite a quantidade">
        </div>
        <div class="form-group" id="barcodes">
          <label for="barcode">Código de Barras:</label>
          <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Digite o codigo de barras">
        </div>-->
        <input type="submit" class="btn card-btn" value="Adicionar Produto">
      </form>
    </div>
  </div>

  

<?php 

  include_once("templates/footer.php");

?>
