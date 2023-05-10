<?php


  class Vehicle {

    public $id;
    public $name;
    public $brand;
    public $model;
    public $plate;
    public $choose;
    public $date_entry;
    public $clients_id;

  }


  interface VehicleDAOInterface{

    public function bildVehicle($data);
    public function create(Vehicle $vehicle, $clients_id);
    public function update(Vehicle $vehicle, $msg, $destiny, $redirect = true);
    public function getVehicles();
    public function findById($id);
    public function findByClient($id);
    public function findByChoose($choose, $id);
    
  }