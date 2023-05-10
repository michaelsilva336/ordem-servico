<?php 

  include_once("templates/header.php");

  
?>


  <div class="container-fluid main-container" >
    <div class="col-md-12" id="back-container">
      <a href="<?= $BASE_URL ?>/oss.php" id="btn-session"class="btn card-btn"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>
    <div class="col-12" id="os-container">
        <h1 class="page-title">Adicionar Os</h1>
        <form action="<?= $BASE_URL ?>/os_process.php" id="add-os-form" method="POST">
        <input type="hidden" name="type" value="create">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="clientName">Nome cliente:</label>
                    <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Nome do cliente" onkeyup="clientLoad('#clientName')">
                </div>
                <div class="form-group col-md-6">
                    <label for="responsible">Técnico/Responsável:</label>
                    <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Nome responsável do serviço">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="status">Finalidade:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Relação Peças">Relação Peças</option>
                        <option value="Orçamento Peças">Orçamento Peças</option>
                        <option value="Orçamento Serviços">Orçamento Serviços</option>
                        <option value="Ordem Serviço">Ordem Serviço</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Data inicial:</label>
                    <input type="date" class="form-control" id="date_start" name="date_start">
                </div>
                <div class="form-group col-md-6">
                    <label for="warranty">Garantia:</label>
                    <input type="text" class="form-control" id="warranty" name="warranty" placeholder="Tempo de garantia">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="defect">Defeito:</label>
                    <textarea name="defect" id="defect" rows="5" class="form-control" placeholder="Descreva o defeito..."></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observation">Observações:</label>
                    <textarea name="observation" id="observation" rows="5" class="form-control" placeholder="Descreva observações..."></textarea>
                </div>
            </div>
            <input type="submit" class="btn card-btn" value="Adicionar Os">
        </form>
    </div>
  </div>    

<?php 

  include_once("templates/footer.php");

?>