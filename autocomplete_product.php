<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("models/Complete.php");


$message = new Message($BASE_URL);
$complete = new Complete($conn, $BASE_URL);



//Auto complete

$productName = filter_input(INPUT_GET, "term");


if(!empty($productName)){

  $product= $complete->autoComplete($productName, "products", "ProductDAO");

  echo json_encode($product);

}else{
  $message->setMessage("Nenhum produto encontrado", "error", "index.php");
}