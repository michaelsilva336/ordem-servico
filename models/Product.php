<?php

  

  class Product {

    public $id;
    public $name;
    public $brand;
    public $unity;
    public $value_buy;
    public $value_sale;
    public $amount;
    public $inventory;
    public $barcode;
    public $entry_date;
    public $users_id;


    public function sumInventory($amount){


    }



  }

  interface ProductDAOInterface {

    public function bildProduct($data);
    public function create(Product $product);
    public function update(Product $product, $redirect = true);
    public function getProducts();
    public function findById($id);
    public function findByName($name);

  }