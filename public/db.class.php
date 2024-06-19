<?php

class DB
{
private $host = 'localhost';
private $user = 'root';
private $pass = 'root';
private $database = 'spongebob';
private $db;

public function __construct($host = null, $user = null, $pass = null, $database = null){
    if($host != null){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }
try{
   $this->db = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->pass,
       array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}catch(PDOException $e){
   die('connection failed: ' . $e->getMessage()); }
}

    public function query($sql, $data = array()){
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }


}