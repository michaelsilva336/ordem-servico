<?php 

  include_once("templates/header.php");
  include_once("dao/ServiceDAO.php");

  $serviceDao= new ServiceDAO($conn, $BASE_URL);


  $id= filter_input(INPUT_GET, "id");

  if(!empty($id)){

    $serviceData= $serviceDao->findById($id);

    if($serviceData){

        $service= $serviceData;

    }else{
        $message->setMessage("Serviço não encontrado", "error", "login.php");
    }

  }else{
    $message->setMessage("Serviço não encontrado", "error", "login.php");
  }


?>

  <div class="container-fluid table-view-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/services.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="col-12 table-view-container">
        <h1 id="view" class="title-table-view">Dados do Serviço</h1>

        <table id="table-view" class="table-bordered">
        <tbody>
            <tr>
            <td>Nome:</td>
            <td><?=$service->name?></td>
            </tr>
            <tr>
            <td>Valor:</td>
            <td><?="R$" . $numb= number_format($service->value, 2, ',', '.')?></td>
            </tr>
            <tr>
            <td>Descrição:</td>
            <td><?=$service->description?></td>
            </tr>
            <tr>
            <td>Data de cadastro:</td>
            <td><?=$service->entry_date?></td>
            </tr>
            <tr>
            <td>Usuário do cadastro:</td>
            <td><?=$service->user_name?></td>
            </tr>
        </tbody>
        </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>