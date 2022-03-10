<?php

class DB{
  public function connect(){
    $pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","mysql");
    return $pdo;
  }

  public function insert(){
    return "insert into login_mypage(name,mail,password,picture,comments)values(?,?,?,?,?)";
  }

  public function select(){
    return "select * from login_mypage where mail = ? && password = ?";
  }

  public function update(){
    return "update login_mypage set name = ?, mail = ?, password = ?, comments = ? where id = ?";
  }
}

?>