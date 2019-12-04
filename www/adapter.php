<?php
abstract class Adapter{

    protected $conn;

    function __construct(){
        $config = parse_ini_file(ROOT.'/config/dbconfig.ini');
        $this->conn = $this->connect($config);
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