<?php




  class ProductOs {

    public $id;
    public $amount;
    public $sub_total;
    public $porcent;
    public $porcent_price_sum;
    public $porcent_value_total;
    public $services_orders_id;
    public $products_id;


    public function sum($value_sale, $amount){

      $resut= $value_sale * $amount;

      return $resut;
    }

    public function subTotal($sub_total){

      $resut += $sub_total;

      return $resut;
    }

  }


  interface ProductOsInterface {

    public function bildProductOs($data);
    public function create(ProductOs $productOs);
    public function getProductsOs();
    public function findById($id);
    public function findByOs($id_os);
    public function inventoryDown($id_os);
    public function inventorySum($id_os);

  }