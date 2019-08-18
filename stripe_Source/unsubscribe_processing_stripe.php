    <div class="title">架空サービス(退会処理）</div>
<?php
  session_start();
  date_default_timezone_set('Asia/Tokyo');
  require_once('./../base.php');

  if(!isset($_SESSION['user_id'])) {
    header('Location: ./../index.php');
  }
  // user_id(userテーブルのno)からemail(メールアドレス)を取得する
  $host     = $DB_acces['host'];
  $username = $DB_acces['username'];
  $passwd   = $DB_acces['passwd'];
  $dbname   = $DB_acces['dbname'];
  // 接続
  $mysqli = new mysqli($host , $username, $passwd, $dbname);
  if($mysqli->connect_error) {
    echo $mysqli->connect_error;
    echo '<a href="./../index.php">ログイン画面へ</a>';
    exit();
  }

  $mysqli->set_charset("utf8");
  $sql = "SELECT email FROM user WHERE no = ?";
  $email = "";
  if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $user_id = $_SESSION['user_id'];
    $stmt->execute();
    $stmt->bind_result($e);
    $stmt->fetch();
    $email = $e;
    $stmt->close();
  } else {
    // クエリに失敗した場合はログイン画面に戻す
    header('Location: ./../index.php');
  }
  $mysqli->close();
 ?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>架空サービス(退会処理)</title>
    <style type="text/css">
    .stripe-button-el {
      width: 100px;
      height: 200px;
      max-width: 100%;
      margin: 10px;
      display: inline-block !important;
    }
    .stripe-button-el span {
      font-size: 18px;
      padding-top: 15px;
      height: 200px !important;
      text-align: center;
      vertical-align: middle !important;
    }
    form {
      float: left;
    }
    </style>
</head>

<body>
    <div class="comment">退会ボタンをクリックで自動請求システムも退会します。いままでご利用ありがとうございました。</div>
    <form action="./charge.php" method="POST">
      <button type="submit" name="cancel" value="退会" class="stripe-button-el"><span style="display:block; min-height:30px;">退会</span></button>
    </form>
</body>
</html>
