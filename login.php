<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">架空サービス(ログイン処理）</div>
<?php

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
    }
       //入力されたe-mailアドレスが登録済みand有効かチェック
       $link->set_charset('utf8');
       $user_select_sql = $link->prepare( "SELECT * FROM user where email = ? AND status = 1");
       $input_id = $_POST['id'];
       $user_select_sql->bind_param("s",$input_id);
       $user_select_sql->execute();
       $result = $user_select_sql->get_result();
       $user_select_all = $result->fetch_all(MYSQLI_ASSOC);

       if(count($user_select_all)>=1){
           $email_check = true;
       }else{
           $email_check = false;
       }

       //自動課金機能機能の期限をチェック
       if(count($user_select_all)>=1 and $email_check = true){
          $today = strtotime(date('Y-m-d'));
          $update_date = strtotime($user_select_all[0]['update_date']);

          if($today<=$update_date or $user_select_all[0]['plan'] == 1):
            $update_date_check = true;
          else :
            $update_date_check = false;
          endif;
       }

       //入力されたe-mailアドレスが登録済みandパスワード認証ok
       if($email_check==true and $update_date_check == true){
            if(password_verify($_POST['password'],$user_select_all[0]['password'])){
                $password_check = true;
                session_start();
                $_SESSION['email'] = $user_select_all[0]['email'];
                $_SESSION['user_id'] = $user_select_all[0]['no'];
                header('Location: fiction_service.php');
            }else{
                $password_check = false;
            }
        }elseif($email_check==true and $update_date_check == false){
                echo "<BR>";
                echo '<div class="comment">ログインに失敗。idが有効期限切れです。ログイン画面に戻って再登録して下さい。</div>';
                echo "<BR>";
                echo '<div class="comment"><a href="index.php">ログイン画面に戻る</a></div>';
                echo "</ul>";
                exit;
       }

       if($email_check==false or $password_check == false){
                echo "<BR>";
                echo '<div class="comment">ログインに失敗。id又はパスワードが間違っています。</div>';
                echo "<BR>";
                echo '<div class="comment"><a href="index.php">ログイン画面に戻る</a></div>';
                echo "</ul>";
                exit;
        }
?>

