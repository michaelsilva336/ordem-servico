<?php 

  include_once("templates/header.php");
  include_once("models/Rows.php");

  $row= new Rows($conn, $BASE_URL);


  date_default_timezone_set('America/Sao_Paulo');


?>

  <div class="container-fluid" id="container-index" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div id="shortcut">
                        <div>
                            <a href="<?=$BASE_URL?>/clients.php" class="btn btn-shortcut" id="client-ico"><i class="fa fa-user"></i><span>Clientes</span></a>
                        </div>
                        <div>
                            <a href="<?=$BASE_URL?>/products.php" class="btn btn-shortcut" id="product-ico"><i class="fa fa-cart-arrow-down"></i><span>Produtos</span></a>
                        </div>
                        <div>
                            <a href="<?=$BASE_URL?>/services.php" class="btn btn-shortcut" id="service-ico"><i class="fa fa-wrench"></i><span>Serviços</span></a>
                        </div>
                        <div>
                            <a href="<?=$BASE_URL?>/oss.php" class="btn btn-shortcut" id="os-ico"><i class="fa fa-tasks"></i><span>Os</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-index">
                    <span id="time-index"><?php echo date('H : i');?></span>
                </div>
                
                    
                
            </div>
        </div>
    </div>
    <div class="col-md-12" >
        <div class="row">
            <div class="col-md-9">

            <!--CALENDÁRIO-->

            </div>
            <div class="col-md-3" id="aside-container">
                <div class="main-menu">
                    <div class="container-duo">
                        <div class="row">
                            <div class="container-ico">
                                
                                <div>
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="span-ico">
                                    <div><span class="span-ico-number"> <?=$rows= $row->getRows("clients", "ClientDAO");?> </span></div>
                                    <div><span class="span-ico-name">Clientes</span></div>
                                </div>
                            
                        
                            </div>
                            <div class="container-ico">

                                <div>
                                    <i class="fa fa-cart-arrow-down"></i>
                                </div>
                                <div class="span-ico">
                                    <div><span class="span-ico-number"><?=$rows= $row->getRows("products", "ProductDAO");?></span></div>
                                    <div><span class="span-ico-name">Produtos</span></div>
                                </div>
                                
                    
                            
                            </div>
                        </div>
                    </div>
                    <div class="container-duo">
                        <div class="row">
                            <div class="container-ico">

                                <div>
                                    <i class="fa fa-wrench"></i>
                                </div>
                                <div class="span-ico">
                                    <div><span class="span-ico-number"><?=$rows= $row->getRows("services", "ServiceDAO");?></span></div>
                                    <div><span class="span-ico-name">Serviços</span></div>
                                </div>

                        
                            </div>
                            <div class="container-ico">

                                <div>
                                    <i class="fa fa-tasks"></i>
                                </div>
                                <div class="span-ico">
                                    <div><span class="span-ico-number"><?=$rows= $row->getRows("services_orders", "OsDAO");?></span></div>
                                    <div><span class="span-ico-name">Os</span></div>
                                </div>
                    
                                
                            
                            </div>
                        </div>
                    </div>
                    <div id="container-off">
                        <div class="row">
                            <div id="power-off">

                                <div><a href="<?=$BASE_URL?>/logout.php"><i class="fa fa-power-off fa-2x"></i></a></div>
                                <div id="span-off"><span>Sair</span></div>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php 

  include_once("templates/footer.php");

?>
