<?php

  class Client {

    public $id;
    public $name;
    public $cpf;
    public $phone;
    public $cell;
    public $email;
    public $rua;
    public $number;
    public $district;
    public $city;
    public $state;
    public $cep;
    public $entry_date;
    public $users_id;

  }


  interface ClientDAOInterface {

    public function bildClient($data);
    public function create(Client $client);
    public function update(Client $client, $redirect = true);
    public function getClients();
    public function findById($id);
    public function findByName($name);
  }