<?php


  class ServiceOs {

    public $id;
    public $sub_total;
    public $services_orders_id;
    public $services_id;
  
  }

  interface ServiceOsInterface {

    public function bildServiceOs($data);
    public function create(ServiceOs $serviceOs);
    public function getServicesOs();
    public function findById($id);

  }