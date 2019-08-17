<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">架空サービス</div>
    <?php
        // セッション開始
        @session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: fiction_service.php');
        }elseif (!isset($_SESSION['user_id'])) {
        }
    ?>
    <form action="/team_development/login.php" method="post">
        <ul>
            <li>Id(e-mail)、パスワードを入力して下さい。</li>
            <li><label class="login">Id(e-mail)：</label><input type="text" name="id" size="40"></li>
            <li><label class="login">パスワード：</label><input type="password" name="password" size="40"></li>
            <BR>
            <li><input type="submit" value="送信"><input type="reset" value="リセット"></li>
            <BR>
            <li><a href="/team_development/new_id.php">Id(e-mail)、パスワードの登録がまだの方はこちら</a></li>
        </ul>
    </form>
    
<?php require(dirname(__FILE__) ."/temp/footer.html"); ?>