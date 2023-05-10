<?php 

  include_once("templates/header.php");
  include_once("models/Product.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/UserDAO.php");

  $productDao= new ProductDAO($conn, $BASE_URL);
  $userDao=  new UserDAO($conn, $BASE_URL);

  $userData= $userDao->verifyToken(true);

  $id= filter_input(INPUT_GET, "id");

  if(empty($id)){

    $message->setMessage("O produto não foi encontrado!", "error", "login.php");

  }else{

    $product= $productDao->findById($id);

    if (!$product) {

        $message->setMessage("O produto não foi encontrado!", "error", "login.php");
    }
  }

?>



  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/products.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="offset-md-4 col-md-4 new-client-container">
      <h1 class="page-title">Editar Produto</h1>
      <form action="<?= $BASE_URL ?>/product_process.php" id="add-client-form" method="POST">
        <input type="hidden" name="type" value="update">
        <input type="hidden" name="id" value="<?=$product->id?>">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do produto" value="<?=$product->name?>">
        </div>
        
        <div class="form-group">
          <label for="unity">Unidade:</label>
          <select name="unity" id="unity" class="form-control">
              <option value="">Selecione</option>
              <option value="CX" <?= $product->unity === "CX" ? "selected" : "" ?> >CX</option>
              <option value="JG" <?= $product->unity === "JG" ? "selected" : "" ?> >JG</option>
              <option value="PC" <?= $product->unity === "PC" ? "selected" : "" ?> >PC</option>
              <option value="LT" <?= $product->unity === "LT" ? "selected" : "" ?> >LT</option>
              <option value="UN" <?= $product->unity === "UN" ? "selected" : "" ?> >UN</option>
          </select>
        </div>

        <div class="form-group">
          <label for="brand">Marca:</label>
          <input type="text" class="form-control" id="brand" name="brand" placeholder="Digite a marca do produto" value="<?=$product->brand?>">
        </div>
        <div class="form-group">
          <label for="value_buy">Valor Compra:</label>
          <input type="text" class="form-control" id="value_buy" name="value_buy" placeholder="Digite o valor de compra" value="<?=$product->value_buy?>">
        </div>
        <!--<div class="form-group">
          <label for="value_sale">Valor Venda:</label>
          <input type="text" class="form-control" id="value_sale" name="value_sale" placeholder="Digite o valor de venda" value="<?=$product->value_sale?>">
        </div>
        <div class="form-group">
          <label for="inventory">Estoque:</label>
          <input type="text" class="form-control" id="inventory" name="inventory" placeholder="Digite o estoque" value="<?=$product->inventory?>">
        </div>-->
        <input type="submit" class="btn card-btn" value="Editar Produto">
      </form>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
