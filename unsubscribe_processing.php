<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">連絡掲示板(退会処理）</div>
<?php
    // セッション開始
    session_start();

    $host     = $DB_acces['host'];
    $username = $DB_acces['username'];
    $passwd   = $DB_acces['passwd'];
    $dbname   = $DB_acces['dbname'];
    // 接続
    $link = new mysqli($host , $username, $passwd, $dbname);

    if ($link->connect_error) {
        echo $link->connect_error;
        exit();
    } else {
        $link->set_charset("utf8");

    $user_del_sql = $link->prepare( "UPDATE `user` SET status= 0 WHERE email = ? ");
    $user_del_sql->bind_param("s",$_POST['id']);
      switch ($user_del_sql->execute()) {
        case true:
          // セッション変数を全て削除
          //$_SESSION = array();

          // セッションの登録データを削除
          //session_destroy();

          echo '<div class="comment">退会処理が完了しました。いままでご利用まことにありがとうございました。</div>';
            header('Location: stripe_Source\subscription.php');
          break;
      case false:
          echo '<div class="comment">退会処理に失敗しました。管理者に連絡して下さい。</div>';
          break;
       }

    }
?>

<?php  $link->close();  ?>
        <ul>
            <BR>
            <li><a href="index.php">ログイン画面に戻る</a></li>
        </ul>

<?php require(dirname(__FILE__) ."/temp/footer.html"); ?>