<?php 

  include_once("db.php");
  include_once("globals.php");
  include_once("dao/UserDAO.php");
  include_once("dao/OsDAO.php");
  include_once("dao/ProductOsDAO.php");
  include_once("dao/ProductDAO.php");
  

  

  $userDao=  new UserDAO($conn, $BASE_URL);
  $osDao= new OsDAO($conn, $BASE_URL);
  $productOsDao= new ProductOsDAO($conn, $BASE_URL);
  $productDao= new ProductDAO($conn, $BASE_URL);
  
 

  $userData= $userDao->verifyToken(true);

  
  $id_os= filter_input(INPUT_GET, "id");

  if(empty($id_os)){

    $message->setMessage("Os não foi encontrado!", "error", "login.php");

  }else{

    $os= $osDao->findById($id_os);

    if (!$os) {

        $message->setMessage("Os não foi encontrado!", "error", "login.php");
    }
  }

  $products_os= $productOsDao->getProductsOs();
 

  //target="_blank"
 
?>



<!doctype html>
    <html lang="pt-br">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Mêcanica JJ</title>
      <link rel="short icon" href="<?= $BASE_URL ?>/img/favicon_m.png" />
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
      <!-- CSS do projeto -->
      <link rel="stylesheet" href="<?= $BASE_URL ?>/css/styles.css">
      <!-- JS do projeto -->
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    </head>
    <body>



        <div class="container" id="container-view-os">

            <div class="row row-os">
                <div class="col-md-3" id="container-logo-company">
                    <img src="<?=$BASE_URL?>/img/logo.png" alt="MecanicaJJ">
                </div>
                <div class="col-md-5" id="container-info-company">
                    <div id="span">
                        <span id="mec">Mecânica JJ</span>
                        <span id="cnpj">CNPJ: 39.484.048/0001-58</span>
                        <span id="cnpj">ENDEREÇO: RUA B2, QD80 LT30 LUÍS EDUARDO MAGALHÃES-BA</span>
                        <span id="cnpj">TELEFONE: (77) 99840-5407</span>
                        <span id="cnpj">E-MAIL: mecanicajj69@gmail.com</span>
                    </div>
                </div>
                <div class="col-md-4" id="container-name-orcamento">
                    <div id="name-orcamento">
                        <span>RELAÇÃO PEÇAS</span>
                    </div>
                    <div id="date-orcamento">
                        <span><?="Emissão: " . $os->date_start?></span>
                    </div>
                </div>
            </div>
            <div class="row row-os">
                <div class="col-md-12 container-title-view-os">
                    <h5>DADOS DO CLIENTE</h5>
                </div>
                <div class="col-md-6" id="container1-info-client">
                    <div>
                        <label for="name">Nome:</label>
                        <span><?=$os->client_name?></span>
                    </div>
                    <div>
                        <label for="adress">Endereço:</label>
                        <span><?=$os->client_rua . " Nº " . $os->client_number?></span>
                        
                    </div>
                    <div>
                        <label for="city">Cidade:</label>
                        <span><?=$os->client_city?></span>
                        
                    </div>
                    <div>
                        <label for="phone">Telefone:</label>
                        <span><?=$os->client_phone?></span>
                    </div>
                </div>
                <div class="col-md-6" id="container2-info-client">
                    <div>
                        <label for="cpf">CPF/CNPJ:</label>
                        <span><?=$os->client_cpf?></span>
                    </div>
                    <div>
                        <label for="district">Bairro:</label>
                        <span><?=$os->client_district?></span>
                    </div>
                    <div>
                        <label for="cep">Cep:</label>
                            <span><?=$os->client_cep?></span>
                    </div>
                    <div>
                        <label for="enail">E-mail:</label>
                        <span><?=$os->client_email?></span>
                    </div>
                </div>
            </div>





            <div class="row row-os-orcamento">
                
                    <div class="col-md-12" id="container-main-title-orcamento">
                        <div class="col-md-1 container-title-orcamento">
                            <h6>Código</h6>
                        </div>
                        <div class="col-md-8 container-title-orcamento">
                            <h6>Descrição</h6>
                        </div>
                        <div class="col-md-1 container-title-orcamento">
                            <h6>Und</h6>
                        </div>
                        <div class="col-md-1 container-title-orcamento">
                            <h6>Qtd</h6>
                        </div>
                    </div>


                    <?php if(!empty($products_os)): ?>
                        <?php foreach($products_os as $product_os): ?>
                            <?php if($product_os->services_orders_id === $os->id): ?>

                                <?php
                                $product= $productDao->findById($product_os->products_id);
                                
                                $product_os->id= $product_os->id;
                                $product_os->name= $product->name;
                                $product_os->qtd= $product_os->amount;
                                $product_os->unid= $product->unity;
                                $product_os->brand= $product->brand;
                                $product_os->porcent_number= $product_os->porcent;
                                $product_os->price_pro= $product->value_buy;
                                $product_os->sub_total_pro= $product_os->sub_total;
                                $product_os->price_porcent= $product_os->porcent_price_sum;
                                $product_os->sub_total_porcent= $product_os->porcent_value_total;
                                $product_os->id_os= $product_os->services_orders_id;

                                $product_os->result_price= (($product_os->porcent_number / 100) * $product_os->price_pro) + $product_os->price_pro;
                                $product_os->result_total_porcent= $product_os->result_price * $product_os->qtd;

                                $productOsDao->update($product_os, false);

                                ?>

                                <div class="col-md-12" id="container-main-data-orcamento">

                                    <div class="col-md-1 container-data-orcamento">
                                        <span><?=$product_os->id?></span>
                                    </div>
                                    <div class="col-md-8 container-data-orcamento" id="name_orc">
                                    <span><?= $product_os->name . ($product_os->brand == NULL ? "" : " | " . $product_os->brand) ?> </span>
                                    </div>
                                    <div class="col-md-1 container-data-orcamento">
                                        <span><?=$product_os->unid?></span>
                                    </div>
                                    <div class="col-md-1 container-data-orcamento">
                                        <span><?=$product_os->qtd?></span>
                                    </div>
                                </div>
                

                            <?php endif;?>
                        <?php endforeach;?>
                    <?php else: ?>
                        <div>
                            <span>Nenhum produto adicionado!</span>
                        </div>
                    <?php endif; ?>

            </div>
        </div>

    </body>
</html>