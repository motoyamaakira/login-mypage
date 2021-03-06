<?php
mb_internal_encoding("utf8");
session_start();

try {
  require "DB.php";
  $db = new DB();
  $pdo = $db->connect();
} catch (PDOException $e) {
  die("<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセスが出来ません。<br>しばらくしてから再度ログインをしてください。</p>
  <a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>"
);
}

$stmt = $pdo->prepare($db->update());

$stmt->bindValue(1,$_POST['name']);
$stmt->bindValue(2,$_POST['mail']);
$stmt->bindValue(3,$_POST['password']);
$stmt->bindValue(4,$_POST['comments']);
$stmt->bindValue(5,$_POST['id']);

$stmt->execute();

$stmt = $pdo->prepare($db->select());
$stmt->bindValue(1,$_POST['mail']);
$stmt->bindValue(2,$_POST['password']);

$stmt->execute();
$pdo = NULL;

while($row = $stmt->fetch()) {
  $_SESSION['id'] = $row['id'];
  $_SESSION['name'] = $row['name'];
  $_SESSION['mail'] = $row['mail'];
  $_SESSION['password'] = $row['password'];
  $_SESSION['picture'] = $row['picture'];
  $_SESSION['comments'] = $row['comments'];
}

header("Location:http://localhost/login_mypage/mypage.php");
?>