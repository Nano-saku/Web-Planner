<?php

require __DIR__.'/../vendor/autoload.php';

use Kreait\Firebase\Factory;


class FirebaseService {
    private $database;
    private $auth;

    public function __construct()
    {
        $factory =(new Factory)->withServiceAccount(__DIR__.'/../serviceAccount.json')
        ->withDatabaseUri('https://webplanner-6c0a0-default-rtdb.asia-southeast1.firebasedatabase.app/');
        $this->database = $factory ->createDatabase();
        $this->auth = $factory->createAuth();
    }

    public function db(){
        return $this->database;
    }
    public function auth(){
        return $this->auth;
    }
}

$firebase = new FirebaseService();