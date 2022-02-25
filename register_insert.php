<?php

mb_internal_encoding("utf8");

$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","root");

$stmt = $pdo->prepare("insert into login_mypage(name,mail,password,picture,comments)values(?,?,?,?,?)");

$stmt->bindValue(1,$_POST['name']);
$stmt->bindValue(2,$_POST['mail']);
$stmt->bindValue(3,$_POST['password']);
$stmt->bindValue(4,$_POST['path_filename']);
$stmt->bindValue(5,$_POST['comments']);

$stmt->execute();
$pdo = NULL;

header("Location:http://localhost/login_mypage/after_register.html");
?>