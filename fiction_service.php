<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">架空サービス</div>    
    <?php
        // セッション開始
        @session_start();
        if (isset($_SESSION['user_id'])) {
        }elseif (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
        }
    ?>
    <?php
        $host     = $DB_acces['host'];
        $username = $DB_acces['username'];
        $passwd   = $DB_acces['passwd'];
        $dbname   = $DB_acces['dbname'];

        $link = new mysqli($host , $username, $passwd, $dbname);

        $link->set_charset('utf8');
        $user_select_sql = $link->prepare( "SELECT * FROM user where no = ?");
        $user_select_sql->bind_param("s",$_SESSION['user_id']);
        $user_select_sql->execute();
        $result = $user_select_sql->get_result();
        $user_select_all = $result->fetch_all(MYSQLI_ASSOC);

        $email = $_SESSION['email'];
    ?>

    <?php if (isset($_SESSION['user_id'])) {?>
        <div class="session">
            <div class="session_id">
                ログインid:<?=$email?>
            </div>
            <?php
              //一般ユーザーの場合、加入中プランを表示
             if($user_select_all[0]['plan'] != 1){?>
            <div class="user_plan">
                加入中プラン：
                <?php if($user_select_all[0]['plan'] == 1000){
                         echo "￥1,000/月(プランA)";
                      }elseif($user_select_all[0]['plan'] == 3000){
                         echo "￥3,000/月(プランB)";
                      }elseif($user_select_all[0]['plan'] == 5000){
                         echo "￥5,000/月(プランC)";
                      }//if($user_select_all[0]['plan'] == 1000) ?>
            </div>
            <?php }?>

            <?php 
              //管理者ユーザーの場合、管理機能画面へのリンクを表示
              if($user_select_all[0]['plan'] == 1){
            ?>
            <div class="user_type">
                 <a href="user_info.php"><-管理機能画面-></a>
            </div>
            <?php }?>

            <div class="session_logout">
                <a href="logout.php">ログアウト</a>
            </div>
            
            <div class="session_footer">
                <div class="unsubscribe">
                    <a href="unsubscribe.php">退会する場合はこちら</a>
                </div>
            </div>

        </div>
    <?php } //if (isset($_SESSION['user_id'])) ?>

<?php require(dirname(__FILE__) ."/temp/footer.html"); ?>