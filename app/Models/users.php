<?php

require __DIR__ . '/../core/firebase.php';

class user {
    private $db;

    public function __construct()
    {
       $firebase = new FirebaseService();
       $this->db = $firebase->db();
    }

    public function login($email, $password, $role){
        return true;
    }

    public function register($email,$name,$password,$role){
        return true;
    }
}

?>