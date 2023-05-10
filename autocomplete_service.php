<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("models/Complete.php");


$message = new Message($BASE_URL);
$complete = new Complete($conn, $BASE_URL);



//Auto complete

$serviceName = filter_input(INPUT_GET, "term");


if(!empty($serviceName)){

  $service= $complete->autoComplete($serviceName, "services", "serviceDAO");

  echo json_encode($service);

}else{
  $message->setMessage("Nenhum serviço encontrado", "error", "index.php");
}