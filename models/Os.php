<?php


  class Os {

    public $id;
    public $date_start;
    public $date_end;
    public $responsible;
    public $warranty;
    public $product_description;
    public $defect;
    public $status;
    public $observation;
    public $vehicle_client;
    public $vehicle_plate;
    public $billed;
    public $clients_id;
    public $users_id;


  }


  interface OsDAOInterface {

    public function bildOs($data);
    public function create(Os $os);
    public function update(Os $os, $redirect, $destiny);
    public function getOss();
    public function findById($id);

  }