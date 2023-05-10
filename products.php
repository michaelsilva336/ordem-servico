<?php 

  include_once("templates/header.php");
  include_once("dao/ProductDAO.php");
  
  $productDao= new ProductDAO($conn, $BASE_URL);

  $query= filter_input(INPUT_GET, "query");

  $products= $productDao->getProducts();

  $productSeach= $productDao->findByNameSearch($query);

 
?>

  <div class="container-fluid main-container">
    <div class="col-md-12" id="back-container">
      <div class="row">
          <div class="col-md-9">
            <a href="<?= $BASE_URL ?>" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
          </div>
          <div class="col-md-3">
            <form action="<?= $BASE_URL ?>/products.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
              <input type="text" name="query" id="search" class="input-form" type="search" placeholder="Buscar Produtos " aria-label="Search">
              <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>
      </div>
    <h2 class="section-title"> Produtos</h2>
    <div class="col-md-12" id="add-clients-container">
        <a href="<?= $BASE_URL ?>/newproduct.php" id="btn-session"class="btn card-btn"><i class="fas fa-plus"></i> Adicionar Produto</a>
    </div>
    <div class="col-md-12" id="clients">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Nome do Produto</th>
          <th scope="col">Marca</th>
          <th scope="col">Valor</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody> 


          <?php if(!empty($query)): ?>

            <?php foreach($productSeach as $productS): ?>

            <tr>
              <td scope="row"> <?=$productS->id?> </td>
              <td><a href="<?= $BASE_URL ?>/viewproduct.php?id=<?=$productS->id?>" class="table-clients-title"> <?=$productS->name?> </a></td>
              <td> <?=$productS->brand?></td>
              <td> <?= "R$" . $numb= number_format($productS->value_buy, 2, ',', '.')?> </td>
              <td class="actions-column">
                <a href="<?= $BASE_URL ?>/editproduct.php?id= <?=$productS->id?> " class="edit-btn">
                  <i class="far fa-edit"></i> Editar
                </a>
                <form action="<?= $BASE_URL ?>/product_process.php" method="POST">
                  <input type="hidden" name="type" value="delete">
                  <input type="hidden" name="id" value="<?=$productS->id?>">
                  <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                </form>
              </td>
            </tr>

            <?php endforeach; ?>

            <?php $query= "";?>

            <?php else: ?>

            <?php foreach($products as $product): ?>
              <tr>
                <td scope="row"> <?=$product->id?> </td>
                <td><a href="<?= $BASE_URL ?>/viewproduct.php?id=<?=$product->id?>" class="table-clients-title"> <?=$product->name?> </a></td>
                <td> <?=$product->brand?></td>
                <td> <?= "R$" . $numb= number_format($product->value_buy, 2, ',', '.')?> </td>
                <td class="actions-column">
                  <a href="<?= $BASE_URL ?>/editproduct.php?id= <?=$product->id?> " class="edit-btn">
                    <i class="far fa-edit"></i> Editar
                  </a>
                  <form action="<?= $BASE_URL ?>/product_process.php" method="POST">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="<?=$product->id?>">
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
