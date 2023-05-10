<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("models/Complete.php");


$message = new Message($BASE_URL);
$complete = new Complete($conn, $BASE_URL);



//Auto complete

$clientName = filter_input(INPUT_GET, "term");


if(!empty($clientName)){

  $client= $complete->autoComplete($clientName, "clients", "ClientDAO");

  echo json_encode($client);

}else{
  $message->setMessage("Nenhum nome encontrado", "error", "index.php");
}