<?php
abstract class Model{

    protected $pdo;

    function __construct(){
        $config = parse_ini_file(ROOT.'/dbconfig.ini');
        $this->pdo = $this->connect($config);
    }

    private function connect($config){
        $host = $config['servername'];
        $db = $config['dbname'];
        $user = $config['username'];
        $pass = $config['password'];
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        return $pdo;
    }

}