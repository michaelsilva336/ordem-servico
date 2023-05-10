<?php 

  include_once("templates/header.php");
  include_once("models/Os.php");
  include_once("models/ProductOs.php");
  include_once("models/ServiceOs.php");
  include_once("dao/OsDAO.php");
  include_once("dao/ProductDAO.php");
  include_once("dao/ServiceDAO.php");
  include_once("dao/VehicleDAO.php");
  include_once("dao/ProductOsDAO.php");
  include_once("dao/ServiceOsDAO.php");
  include_once("dao/UserDAO.php");

  $productModel= new ProductOs();
  $serviceModel= new ServiceOs();
  $userDao=  new UserDAO($conn, $BASE_URL);
  $osDao= new OsDAO($conn, $BASE_URL);
  $productDao= new ProductDAO($conn, $BASE_URL);
  $serviceDao= new ServiceDAO($conn, $BASE_URL);
  $vehicleDao= new VehicleDAO($conn, $BASE_URL);
  $productOsDao= new ProductOsDAO($conn, $BASE_URL);
  $serviceOsDao= new ServiceOsDAO($conn, $BASE_URL);
  $productOs= new ProductOs();

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

  $services_os= $serviceOsDao->getServicesOs();

  $vehicleData= $vehicleDao->findByClient($os->clients_id);

  $resut_pro= 0;
  $resut_ser= 0;

  

?>


  <div class="container " id="container-edit-os" >

    <div class="row" id="container-btn-view">
      <div class="col-md-12" id="title-edit-os">
        <h1 class="page-title">Editar Os</h1>
      </div>
    </div>



    <div class="row" id="container-tree-btn-os">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4" id="btn-orcamento">
            <a href="<?= $BASE_URL ?>/relacaopeca.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Relação Peças</a>
          </div>
          <div class="col-md-4" id="btn-view">
            <a href="<?= $BASE_URL ?>/orcamento.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Orçamento Peças</a>
          </div>
          <div class="col-md-4" id="btn-view">
            <a href="<?= $BASE_URL ?>/viewos.php?id= <?=$os->id?>" id="btn-view-os"class="btn card-btn"><i class="fa fa-eye"></i> Ordem de Serviço</a>
          </div>
        </div>
      </div>
    </div>




    <div class="col-md-12" id="container-section">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="tre">Os</a>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Adicionar Produtos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">Adicionar Serviços</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="vehicle-tab" data-toggle="tab" href="#vehicle" role="tab" aria-controls="vehicle" aria-selected="true">Adicionar Veículo</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        
        <form action="<?= $BASE_URL ?>/os_process.php" id="add-os-form" method="POST">
        <input type="hidden" name="type" value="update">
        <input type="hidden" name="id" value="<?=$os->id?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="clientName">Nome cliente:</label>
                    <input type="text" readonly class="form-control disabled" id="clientName" name="clientName" placeholder="Nome do cliente"  value="<?=$os->client_name?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="responsible">Técnico/Responsável:</label>
                    <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Nome responsável do serviço" value="<?=$os->responsible?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Relação Peças" <?= $os->status === "Relação Peças" ? "selected" : "" ?> >Relação Peças</option>
                        <option value="Orçamento Peças" <?= $os->status === "Orçamento Peças" ? "selected" : "" ?>>Orçamento Peças</option>
                        <option value="Orçamento Serviços" <?= $os->status === "Orçamento Serviços" ? "selected" : "" ?>>Orçamento Serviços</option>
                        <option value="Ordem Serviço" <?= $os->status === "Ordem Serviço" ? "selected" : "" ?>>Ordem Serviço</option>
                        <option value="Finalizado" <?= $os->status === "Finalizado" ? "selected" : "" ?>>Finalizado</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Data inicial:</label>
                    <input type="date" class="form-control" id="date_start" name="date_start" value="<?=$os->date_start?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_end">Data final:</label>
                    <input type="date" class="form-control" id="date_end" name="date_end" value="<?=$os->date_end?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="warranty">Garantia:</label>
                    <input type="text" class="form-control" id="warranty" name="warranty" placeholder="Tempo de garantia" value="<?=$os->warranty?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="defect">Defeito:</label>
                    <textarea name="defect" id="defect" rows="5" class="form-control" placeholder="Descreva o defeito..."> <?=$os->defect?> </textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observation">Observações:</label>
                    <textarea name="observation" id="observation" rows="5" class="form-control" placeholder="Descreva observações..."> <?=$os->observation?> </textarea>
                </div>
            </div>
            <input type="submit" class="btn card-btn" value="Editar Os">
        </form>

        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

          <form action="<?= $BASE_URL ?>/os_process.php" id="add-os-form" method="POST">
              <input type="hidden" name="type" value="create-product-os">
              <input type="hidden" name="id-os" value="<?=$os->id?>">
              <div class="form-row">
                  <div class="form-group col-md-10">
                      <label for="productName">Selecionar Produtos:</label>
                      <input type="text" class="form-control" id="productName" name="productName" placeholder="Selecione o produto" onkeyup="productLoad('#productName')">
                  </div>
                  <div class="form-group col-md-2">
                      <label for="amount">Quantidade:</label>
                      <input type="text" class="form-control" id="amount" name="amount" placeholder="Digite a quantidade">
                  </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                      <input type="submit" class="btn card-btn" value="Adicionar Produto">
                </div>
              </div>
          </form>
          
          <?php if(!empty($products_os)): ?>
            <?php foreach($products_os as $product_os): ?>
              <?php if($os->id === $product_os->services_orders_id): ?>
                <?php
                
                  $productData= $productDao->findById($product_os->products_id);   
                  
                  $product_os->productId= $productData->id;
                  $product_os->productName= $productData->name;
                  $product_os->productUnity= $productData->unity;
                  $product_os->productValueBuy= $productData->value_buy;

                ?>
                <div class="row">
                  <div class="col-md-12 container-product-os">
                    <table class="table-product-os">
                      <thead>
                        <th scope="col">Qtd</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Valor Unitario</th>
                        <th scope="col">Ações</th>
                      </thead>
                      <tbody> 
                        <tr>
                          <td> <?=$product_os->amount?> </td>
                          <td class="name-product"><a href="<?= $BASE_URL ?>/viewproduct.php?id=<?=$product_os->products_id?>" class="table-clients-title"> <?=$product_os->productName?> </a></td>
                          <td> <?=$product_os->productUnity?> </td>
                          <td> <?= $numb= number_format($product_os->productValueBuy, 2, ',', ' ') ?> </td>
                            <td class="actions-column">
                              <form action="<?= $BASE_URL ?>/os_process.php" method="POST">
                                  <input type="hidden" name="type" value="delete-product-os">
                                  <input type="hidden" name="id-product-os" value=" <?=$product_os->id?> ">
                                  <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                              </form>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <?php 

                  $resut_pro += $product_os->sub_total;
                ?>

              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-md-12" id="p-get">
              <p>Nenhum produto adicionado!</p>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-md-12" id="container-value">
                  <span class="sub-total">Sub-Total:</span>
                  <span class="value-sub-total">R$<?= $numb= number_format($resut_pro, 2, ',', '.')?></span>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

          <form action="<?= $BASE_URL ?>/os_process.php" id="add-os-form" method="POST">
              <input type="hidden" name="type" value="create-service-os">
              <input type="hidden" name="id-os" value="<?=$os->id?>">
              <div class="form-row">
                  <div class="form-group col-md-12">
                      <label for="serviceName">Selecionar Serviços:</label>
                      <input type="text" class="form-control" id="serviceName" name="serviceName" placeholder="Selecione o serviço" onkeyup="serviceLoad('#serviceName')">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-12">
                      <input type="submit" class="btn card-btn" value="Adicionar serviço">
                  </div>
              </div>
          </form>
          <?php if(!empty($services_os)): ?>
            <?php foreach($services_os as $service_os): ?>
              <?php if($os->id === $service_os->services_orders_id): ?>
                <?php
                  $serviceData= $serviceDao->findById($service_os->services_id);   
                
                  $service_os->serviceName= $serviceData->name;
                  $service_os->serviceValue= $serviceData->value;
                  $service_os->serviceDescription= $serviceData->description;
                ?>
              <div class="row">
                <div class="col-md-12 container-product-os">
                  <table class="table-product-os">
                    <thead>
                      <th scope="col">Nome</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Descrição</th>
                      <th scope="col">Ações</th>
                    </thead>
                    <tbody> 
                      <tr>
                        <td class="name-product"><a href="<?= $BASE_URL ?>/viewservice.php?id=<?=$service_os->services_id?>" class="table-clients-title"> <?=$service_os->serviceName?> </a></td>
                        <td> <?=$numb= number_format($service_os->serviceValue, 2, ',', ' ')?> </td>
                        <td> <?=$service_os->serviceDescription?> </td>
                          <td class="actions-column">
                            <form action="<?= $BASE_URL ?>/os_process.php" method="POST">
                                <input type="hidden" name="type" value="delete-service-os">
                                <input type="hidden" name="id-service-os" value=" <?=$service_os->id?> ">
                                <button type="submit" class="delete-btn"><i class="fas fa-times"></i> Deletar</button>
                            </form>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <?php
                $resut_ser += $service_os->sub_total;
              ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-md-12" id="p-get">
              <p>Nenhum serviço adicionado!</p>
            </div>
          <?php endif; ?>


          <div class="row">
            <div class="col-md-12" id="container-value">
                  <span class="sub-total">Sub-Total:</span>
                  <span class="value-sub-total">R$<?=$resut_ser?></span>
            </div>
          </div>
        </div>


        <div class="tab-pane fade" id="vehicle" role="tabpanel" aria-labelledby="vehicle-tab">

          <div class="col-md-12" id="title-vehicle-os">
            <h6>Veículos cadastrados do cliente</h6>
          </div>
          <?php if(!empty($vehicleData)): ?>
            <?php foreach($vehicleData as $vehicle_os): ?>
              <div class="row">
                <?php if($vehicle_os->choose === "true"):?>
                  <div class="col-md-1" id="check-vehicle">
                    <i class="fa fa-check-circle"></i>
                  </div>
                <?php endif;?>
                <div class="col-md-11 container-product-os">
                  <table class="table-product-os">
                    <thead>
                      <th scope="col">Nome</th>
                      <th scope="col">Marca</th>
                      <th scope="col">Modelo</th>
                      <th scope="col">Placa</th>
                      <th scope="col">Ações</th>
                    </thead>
                    <tbody> 
                      <tr>
                        <td class="name-product"><a href="<?= $BASE_URL ?>/viewvehicle.php?id=<?=$vehicle_os->id?>" class="table-clients-title"> <?=$vehicle_os->name?> </a></td>
                        <td> <?=$vehicle_os->brand?> </td>
                        <td> <?=$vehicle_os->model?> </td>
                        <td> <?=$vehicle_os->plate?>  </td>
                          <td>
                            <form action="<?= $BASE_URL ?>/vehicle_process.php" method="POST">
                                <input type="hidden" name="type" value="vehicle-os">
                                <input type="hidden" name="id-vehicle-os" value=" <?=$vehicle_os->id?> ">
                                <input type="hidden" name="id-client" value=" <?=$os->client_id?> ">
                                <input type="hidden" name="id-os-vehicle" value=" <?=$os->id?> ">
                                <button type="submit" class="delete-btn">Selecionar</button>
                                <!-- Preencher um campo do cliente para puxar na os -->
                            </form>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-md-12" id="p-get">
              <p>Nenhum veículo adicionado no nome do cliente!</p>
            </div>
          <?php endif; ?>


        </div>
      </div>
    </div>
  </div>

  
  
<?php 

  include_once("templates/footer.php");

?>
