<?php

class AuthentificationManager {
  private $authentification;
  private $error;

  public function __construct(Array $authentification){
    $this->authentification = $authentification;
    $this->error= array();
  }

  public function geterror(){
      return $this->error;
  }

  public function UserConnect($login,$password){
    foreach($this->authentification as $key =>$value){
      if($login == $value->getlog()){
        if(password_verify($value->getpass(), $password)) {
          $_SESSION[$value->getmode()] = $value;
          return true;
        }
      }
    }
    return false;
  }

  public function isUserConnected(){
    if(key_exists("user",$_SESSION)){
      return true;
    }else
      return false;
  }

  public function isAdminConnected(){
    if(key_exists("admin",$_SESSION)){
      return true;
    }else
      return false;
    }
  }
  
?>
