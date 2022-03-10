<?php
mb_internal_encoding("utf8");
session_start();

if(empty($_POST['from_mypage'])){
  header("Location:login_error.php");
}

try{
  require "DB.php";
  $db = new DB();
  $pdo = $db->connect();
} catch(PDOException $e) {
die("<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセスが出来ません。<br>しばらくしてから再度ログインをしてください。</p>
<a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>"
);
}

$stmt = $pdo->prepare($db->select());

$stmt->bindValue(1,$_POST["mail"]);
$stmt->bindValue(2,$_POST["password"]);

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

if(empty($_SESSION['id'])){
  header("Location:login_error.php");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>マイページ登録</title>
    <link rel="stylesheet" type="text/css" href="mypage_hensyu.css">
  </head>
  <bady>
    <header>
      <img src="4eachblog_logo.jpg">
      <div class="logout"><a href="log_out.php">ログアウト</a></div>
    </header>

    <main>
      <div class="box">
        <h2>会員情報</h2>
        <div class="hello">
          <?php echo "こんにちは! ".$_SESSION['name']." さん"?>
        </div>
        <form action="mypage_update.php" method="post">
          <div class="profile_pic">
            <img src="<?php echo $_SESSION['picture']?>">
          </div>
          <div class="basic_info">
            <div class="name">
              <label>氏名:</label>
              <input type="text" class="formbox" size="40" name="name" value="<?php echo $_SESSION['name']?>" required>
            </div>
            <div class="mail">
              <label>メール:</label>
              <input type="text" class="formbox" size="40" name="mail" value="<?php echo $_SESSION['mail']?>" required>
            </div>
            <div class="password">
              <label>パスワード:</label>
              <input type="text" class="formbox" size="40" name="password" value="<?php echo $_SESSION['password']?>" required>
            </div>
          </div>
          <div class="comments">
            <textarea rows="3" cols="70" name="comments"><?php echo $_SESSION['comments']?></textarea>
          </div>
          
          <input type="hidden" name="id" value="<?php echo $_SESSION['id']?>">
  
          <div class="button">
            <input type="submit" class="hensyu_button" value="この内容に変更する">
          </div>
        </form>
      </div>
    </main>

    <footer>
      © 2018 InterNous.inc.All rights reserved
    </footer>
  </body>
</html>