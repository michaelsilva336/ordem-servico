<?php

  include_once("models/User.php");
  include_once("models/Message.php");


  class UserDAO implements UserDAOInterface {

    private $conn;
    private $url;
    private $message;


    public function __construct(PDO $conn, $url){

        $this->conn= $conn;
        $this->url= $url;
        $this->message= new Message($url);
    }






    public function bildUser($data){

        $user= new User();

        $user->id= $data["id"];
        $user->name= $data["name"];
        $user->user= $data["user"];
        $user->password= $data["password"];
        $user->token= $data["token"];
        $user->priority= $data["priority"];

        return $user;

    }


    public function create(User $user){

        $stmt= $this->conn->prepare("INSERT INTO users (name, user, password, priority) VALUE (:name, :user, :password, :priority)");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":user", $user->user);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":priority", $user->priority);

        $stmt->execute();
        

    }


    public function update(User $user, $redirect = true){

        $stmt= $this->conn->prepare("UPDATE users SET name= :name, user= :user, password= :password, token= :token, priority= :priority WHERE id= :id");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":user", $user->user);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":priority", $user->priority);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        if($redirect){

            $this->message->setMessage("Dados atualizados com sucesso!", "success", "back");
        }
    }

    public function setTokenToSession($token, $redirect = true){

        //Salvar token na session
        $_SESSION["token"]= $token;

        if($redirect){

            $this->message->setMessage("Seja bem-vindo!", "success", "index.php");
        }



    }

    public function authenticateUser($user, $password){

        $user= $this->findByUser($user);

        if($user){

            //checar se as senhas batem
            if(password_verify($password, $user->password)){

                //Gerar um token e inserir na session
                $token= $user->generateToken();

                $this->setTokenToSession($token, false);

                //Atualiza o token do usuário
                $user->token= $token;

                $this->update($user, false);

                return true;

            }else{
                return false;
            }

        }else{
            return false;
        }

    }


    public function findByUser($user){

        if($user != ""){

            $stmt= $this->conn->prepare("SELECT * FROM users WHERE user= :user");

            $stmt->bindParam(":user", $user);

            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data= $stmt->fetch();
                $userBild= $this->bildUser($data);

                return $userBild;


            }else{
                return false;
            }

        }else{
            return false;
        }

    }


    public function verifyToken($protected = false){

        if(!empty($_SESSION["token"])){

            $token= $_SESSION["token"];

            $user= $this->findByToken($token);

            if($user){

                return $user;

            }else if($protected){

                $this->message->setMessage("Faça o login para continuar!", "error", "login.php");
            }

        }else if($protected){

            $this->message->setMessage("Faça o login para continuar!", "error", "login.php");
        }

    }


    public function findByToken($token){

        if($token != ""){

            $stmt= $this->conn->prepare("SELECT * FROM users WHERE token= :token");

            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $userBild = $this->bildUser($data);
                
                return $userBild;
      
            }else{
                return false;
            }

        }else{
            return false;
        }

    }


    public function destroyToken(){

      // Remove o token da session
      $_SESSION["token"] = "";

      // Redirecionar e apresentar a mensagem de sucesso
      $this->message->setMessage("Logout feito com sucesso!", "success", "login.php");

    }




    public function findById($id){

        $stmt= $this->conn->prepare("SELECT * FROM users WHERE id= :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $array= $stmt->fetch();

            $user= $this->bildUser($array);
    
            return $user;

        }else{
            return false;
        }
    }

  }