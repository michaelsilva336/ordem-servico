<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("models/Complete.php");


$message = new Message($BASE_URL);
$complete = new Complete($conn, $BASE_URL);



//Auto complete

$vehicleName = filter_input(INPUT_GET, "term");


if(!empty($vehicleName)){

  $vehicle= $complete->autoComplete($vehicleName, "vehicles", "VehicleDAO");

  echo json_encode($vehicle);

}else{
  $message->setMessage("Nenhum veículo encontrado", "error", "index.php");
}