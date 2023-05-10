<?php



  class Service {

    public $id;
    public $name;
    public $value;
    public $description;
    public $entry_date;
    public $users_id;


  }


  interface ServiceDAOInterface {

    public function bildService($data);
    public function create(Service $service);
    public function update(Service $service, $redirect = true);
    public function getServices();
    public function findById($id);
    public function findByName($name);

  }