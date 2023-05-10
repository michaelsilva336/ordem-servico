<?php 

  include_once("templates/header.php");
  include_once("dao/ClientDAO.php");

  $clientDao= new ClientDAO($conn, $BASE_URL);


  $id= filter_input(INPUT_GET, "id");

  if(!empty($id)){

    $clientData= $clientDao->findById($id);

    if($clientData){

        $client= $clientData;

    }else{
        $message->setMessage("Cliente não encontrado", "error", "login.php");
    }

  }else{
    $message->setMessage("Cliente não encontrado", "error", "login.php");
  }


?>



  <div class="container-fluid table-view-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/clients.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="col-12 table-view-container">
        <h1 id="view" class="title-table-view">Dados do Cliente</h1>

        <table id="table-view" class="table-bordered">
        <tbody>
            <tr>
            <td>Nome:</td>
            <td><?=$client->name?></td>
            </tr>
            <tr>
            <td>CPF/CNPJ:</td>
            <td><?=$client->cpf?></td>
            </tr>
            <tr>
            <td>Telefone:</td>
            <td><?=$client->phone?></td>
            </tr>
            <tr>
            <td>Celular:</td>
            <td><?=$client->cell?></td>
            </tr>
            <tr>
            <td>E-mail:</td>
            <td><?=$client->email?></td>
            </tr>
            <tr>
            <td>Rua:</td>
            <td><?=$client->rua?></td>
            </tr>
            <tr>
            <td>N°:</td>
            <td><?=$client->number?></td>
            </tr>
            <tr>
            <td>Bairro:</td>
            <td><?=$client->district?></td>
            </tr>
            <tr>
            <td>Cidade:</td>
            <td><?=$client->city?></td>
            </tr>
            <tr>
            <td>Estado:</td>
            <td><?=$client->state?></td>
            </tr>
            <tr>
            <td>Cep:</td>
            <td><?=$client->cep?></td>
            </tr>
            <tr>
            <td>Data do Cadastro:</td>
            <td><?=$client->entry_date?></td>
            </tr>
            <tr>
            <td>Usuário do cadastro:</td>
            <td><?=$client->user_name?></td>
            </tr>
        </tbody>
        </table>
    </div>
  </div>



<?php 

  include_once("templates/footer.php");

?>
