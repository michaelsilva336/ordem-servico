<?php

  class User {

    public $id;
    public $name;
    public $user;
    public $password;
    public $token;
    public $priority;


    public function generateToken(){

        return bin2hex(random_bytes(50));
    }


    public function generatePassword($password){

        return password_hash($password, PASSWORD_DEFAULT);
    }

  }


  interface UserDAOInterface {

    public function bildUser($data);
    public function create(User $user);
    public function update(User $user, $redirect = true);
    public function setTokenToSession($token, $redirect = true);
    public function authenticateUser($user, $password);
    public function findByUser($user);
    public function verifyToken($protected = false);
    public function findByToken($token);
    public function destroyToken();
    public function findById($id);
  }