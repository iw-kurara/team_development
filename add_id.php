<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">架空サービス(id登録処理）</div>
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
            $user_select_all=user_select( $link,"rege_mail",$_POST['id']);

            if($user_select_all=="0"){
                   //未登録の場合
                $email_check = true;
                $add_type    = "insert";
            }else{

                $user_select2_all=user_select( $link,"rege_invalid_mail",$_POST['id']);

                if ($user_select2_all!="0") :
                    //登録済みで無効の場合
                    $email_check = true;
                    $add_type    = "update";
                    $expiration_date = "etc";
                else :
                    //登録済みで有効の場合、更新日をチェック
                      $today = strtotime(date('Y-m-d'));
                      $update_date = strtotime($user_select_all[0]['update_date']);

                      if($today<=$update_date):
                                $email_check = false;
                                $add_type    = false;
                      else :
                                $email_check = true;
                                $add_type    = "update";
                                $expiration_date = false;
                      endif;
                endif;
            }
    }

 if($email_check==true){
    //登録処理実行(事前チェックの結果でupdateかinsertか分岐)
      $password_text = password_hash($_POST['password1'], PASSWORD_DEFAULT);

       if ($add_type == "insert") :
            $user_add_sql = $link->prepare( "INSERT INTO user (no,email,password,status)VALUES (NULL, ? , ? ,'1')");
            $user_add_sql->bind_param("ss",$_POST['id'],$password_text);
        elseif ($add_type == "update") :
            $user_add_sql = $link->prepare( "UPDATE `user` SET status= 1,password = ? WHERE email = ?");
            $user_add_sql->bind_param("ss",$password_text,$_POST['id']);
        endif;

      switch ($user_add_sql->execute()) {
        case true:
             session_start();
           if ($add_type == "insert") :
                $_SESSION['user_id'] = $user_add_sql->insert_id;
                $_SESSION['email'] = $_POST['id'];
            elseif ($add_type == "update" and  $expiration_date == false) :
                $_SESSION['user_id'] = $user_select_all[0]["no"];
                $_SESSION['email'] = $_POST['id'];
            elseif ($add_type == "update" and  $expiration_date == "etc") :
                $_SESSION['user_id'] = $user_select2_all[0]["no"];
                $_SESSION['email'] = $_POST['id'];
            endif;
            header('Location: stripe_Source\subscription.php');
          break;
      case false:
          echo '<div class="comment">登録に失敗しました。管理者に連絡して下さい。</div>';
          break;
       }
?>
<?php }else{ ?>
       <div class="comment">入力されたidは登録済みです。</div>
<?php }//if ($email_check==true){ ?>

<?php  $link->close();  ?>
        <ul>
            <BR>
            <li><a href="index.php">ログイン画面に戻る</a></li>
        </ul>

<?php require(dirname(__FILE__) ."/temp/footer.html"); ?>