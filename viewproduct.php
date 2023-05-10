<?php 

  include_once("templates/header.php");
  include_once("dao/ProductDAO.php");

  $productDao= new ProductDAO($conn, $BASE_URL);


  $id= filter_input(INPUT_GET, "id");

  if(!empty($id)){

    $productData= $productDao->findById($id);

    if($productData){

        $product= $productData;

    }else{
        $message->setMessage("Produto não encontrado", "error", "login.php");
    }

  }else{
    $message->setMessage("Produto não encontrado", "error", "login.php");
  }
  
 

?>



  <div class="container-fluid table-view-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/products.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="col-md-12">
        <h1 id="view" class="title-table-view">Dados do Produto</h1>
        <table id="table-view" class="table-bordered">
        <tbody>
            <tr>
            <td>Nome:</td>
            <td><?=$product->name?></td>
            </tr>
            <tr>
            <td>Unidade:</td>
            <td><?=$product->unity?></td>
            </tr>
            <tr>
            <td>Valor de compra:</td>
            <td> <?php echo "R$" . $numb= number_format($product->value_buy, 2, ',', '.')?> </td>
            </tr>
            <tr>
            <td>Valor de venda:</td>
            <td><?=$product->value_sale?></td>
            </tr>
            <tr>
            <td>Estoque:</td>
            <td><?=$product->inventory?></td>
            </tr>
            <tr>
            <td>Data de cadastro:</td>
            <td><?=$product->entry_date?></td>
            </tr>
            <tr>
            <td>Usuário do cadastro:</td>
            <td><?=$product->user_name?></td>
            </tr>
        </tbody>
        </table>
    </div>
    
    <!--<div class="col-md-12">
      <form action="<?=$BASE_URL?>/product_process.php" method="POST" id="form-add-stock">
        <input type="hidden" name="type" value="add-stock">
        <input type="hidden" name="id-pro" value="<?=$product->id?>">
        <div class="form-group">
          <label for="amount">Adicionar Produto no estoque:</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Digite a quantidade">
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar Produto">
      </form>
    </div>-->
    
  </div>

<?php 

  include_once("templates/footer.php");

?>
