<?php 

  include_once("templates/header.php");
  include_once("dao/UserDAO.php");
  include_once("dao/OsDAO.php");
  include_once("dao/ProductOsDAO.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/ServiceOsDAO.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/VehicleDAO.php");
 

  

  $userDao=  new UserDAO($conn, $BASE_URL);
  $osDao= new OsDAO($conn, $BASE_URL);
  $productOsDao= new ProductOsDAO($conn, $BASE_URL);
  $productDao= new ProductDAO($conn, $BASE_URL);
  $serviceOsDao= new ServiceOsDAO($conn, $BASE_URL);
  $serviceDao= new ServiceDAO($conn, $BASE_URL);
  $vehicleDao= new VehicleDAO($conn, $BASE_URL);
 


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
  $porcent= $productOsDao->findByOs($os->id);
  
  $services_os= $serviceOsDao->getServicesOs();

  $vehicles= $vehicleDao->getVehicles();

  if($porcent == NULL){
    $porcent[2]= 0;
  }

 

  $value_pro= 0;
  $value_ser= 0;

  $value_porcent= 0;

  //target="_blank"
 
?>



  <div class="container" id="container-view-os">

    <div class="row" id="container-btn-view">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4" id="btn-print">
            <a href="<?= $BASE_URL ?>/editos.php?id= <?=$os->id?>" id="btn-back"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
          </div>
          <div class="col-md-4" id="title-edit-os">
          </div>
          <div class="col-md-4" id="btn-view">
          <a href="<?= $BASE_URL ?>/osprint.php?id= <?=$os->id?>" target="_blank" id="btn-print-os"class="btn card-btn"><i class="fa fa-eye"></i> Imprimir Os</a>
          </div>
        </div>
      </div>
    </div>

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
        <div class="col-md-4" id="container-num-os">
            <div id="num-os">
                <label for="num-os">OS Nº:</label>
                <span> 0<?=$os->id?> </span>
            </div>
            <div id="dates-os">
                <div class="date">
                    <label for="date-start">Data de Abertura:</label>
                     <span> <?=$os->date_start?></span>
                </div>
                <div class="date">
                    <label for="date-end">Data de Fechamento:</label>
                    <span><?= $os->status === "Finalizado" ? $os->date_end : "--/--/----" ?></span>  
                </div>
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
                <span><?=$os->client_rua . ", Nº " . $os->client_number?></span>
                
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
    <div class="row row-os">
        <div class="col-md-12 container-title-view-os">
            <h5>INFORMAÇOES DO VEÍCULO</h5>
        </div>
        <div class="col-md-12" id="container-info-vehicle">
            <?php foreach($vehicles as $vehicle): ?>
                <?php if($os->client_id === $vehicle->clients_id && $vehicle->choose === "true"): ?>
                    <div>
                        <label for="nameCar">Nome:</label>
                        <span><?=$vehicle->name?></span>
                    </div>
                    <div>
                        <label for="brand">Marca:</label>
                        <span><?=$vehicle->brand?></span>
                    </div>
                    <div>
                        <label for="brand">Modelo:</label>
                        <span><?=$vehicle->model?></span>
                    </div>
                    <div>
                        <label for="brand">Placa:</label>
                        <span><?=$vehicle->plate?></span>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
    <div class="row row-os">
        <div class="col-md-12 container-title-view-os">
            <h5>DEFEITO</h5>
        </div>
        <div class="col-md-12" id="container-info-defect">
            <p><?=$os->defect?></p>
        </div>
    </div>
    <div class="row row-os">
        <div class="col-md-12 container-title-view-os">
            <h5 id="title-desc-pro-ser">DESCRIÇÃO PRODUTOS E SERVIÇOS</h5>
        </div>
        <div class="col-md-7" id="container-info-pro">
            <div class="col-md-12 container-title-view-os">
                <h6>PRODUTOS</h6>
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

                        <div class="get-data">
                        <span><?="- "  . $product_os->name . " x" . $product_os->qtd . " | "  . $product_os->unid . " | " . " Valor: " . "R$" . ($product_os->porcent_number <= 0 ? $numb= number_format($product_os->price_pro, 2, ',', '.') : $numb= number_format($product_os->price_porcent, 2, ',', '.'))  . " | Valor total: " . "R$" . ($product_os->porcent_number <= 0 ? $numb= number_format($product_os->sub_total_pro, 2, ',', '.') : $numb= number_format($product_os->sub_total_porcent, 2, ',', '.')) ?></span>
                        </div>

                        <?php 
                            $product_os->porcent_number <= 0 ? $value_pro += $product_os->sub_total_pro : $value_porcent += $product_os->sub_total_porcent; 
                            
                        ?>

                    <?php endif;?>
                <?php endforeach;?>
            <?php else: ?>
                <div>
                    <span>Nenhum produto adicionado!</span>
                </div>
            <?php endif; ?>

            <?php $osFinished;?>
            
        </div>  
        <div class="col-md-5" id="container-info-ser">
            <div class="col-md-12 container-title-view-os">
                <h6>SERVIÇOS</h6>
            </div>
            <?php if(!empty($services_os)): ?>
                <?php foreach($services_os as $service_os): ?>
                    <?php if($os->id === $service_os->services_orders_id): ?>
                        <?php
                            $serviceData= $serviceDao->findById($service_os->services_id);   
                            
                            $service_os->serviceName= $serviceData->name;
                            $service_os->serviceValue= $serviceData->value;
                        ?>

                        <div class="get-data">
                            <span><?=$service_os->serviceName . " | " . " R$" . $numb= number_format($service_os->serviceValue, 2, ',', '.')?></span>
                        </div>

                        <?php $value_ser += $service_os->sub_total?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php else: ?>
                <div>
                    <span>Nenhum serviço adicionado!</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row row-os">
        <div class="col-md-12 container-title-view-os">
            <h5>GARANTIA E OBSERVAÇÕES</h5>
        </div>
        <div class="col-md-12" id="container-info-obs">
            <?=$os->warranty?></br>
            <?=$os->observation?>
        </div>
    </div>
    <div class="row row-os">
        <div class="col-md-12 container-title-view-os">
            <h5 id="title-orc">ORÇAMENTO</h5>
        </div>
        <div class="col-md-6" id="container1-info-orc">
            <div>
                <p>Valor Produtos/Peças:</p>
            </div>
            <div>
                <p>Valor Serviços:</p>
            </div>
        </div>
        <div class="col-md-3" id="container2-info-orc">
            <div>
                <p><?="R$" . ($porcent[2] <= 0 ? $numb= number_format($value_pro, 2, ',', '.') : $numb= number_format($value_porcent, 2, ',', '.')) ?></p>
            </div>
            <div>
                <p><?="R$" . $numb= number_format($value_ser, 2, ',', ' ')?></p>
            </div>  
        </div>
        <div class="col-md-3"  id="container-value-total">
            <div>
                <span id="label-value-total">Valor Total:</span>
                <span id="value-total"> <?="R$" . ($porcent[2] <= 0 ? $numb= number_format($total= $value_pro + $value_ser, 2, ',', '.') : $numb= number_format($total= $value_porcent + $value_ser, 2, ',', '.')) ?></span>
            </div>
        </div>
    
    
        <div class="col-md-6" class="container-ass">
            <div class="ass-p">
                <p>Assinatura do Cliente</p>
            </div>
        </div>
        <div class="col-md-6" class="container-ass">
            <div class="ass-p">
                <p>Assinatura do Responsável/Técnico</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="<?=$BASE_URL?>/os_process.php" method="POST" id="form-add-stock">
                <input type="hidden" name="type" value="add-porcent">
                <input type="hidden" name="id_os" value="<?=$os->id?>">
                <div class="form-group">
                    <label for="amount">Adicionar Pocentagem:</label>
                    <input type="text" class="form-control" id="porcent" name="porcent" placeholder="Digite somente numeros" value="<?= $porcent[2] . "%"?>">
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar">
            </form>
        </div>
    </div>


  </div>

<?php 

  include_once("templates/footer.php");

?>