<?php require(dirname(__FILE__) ."/temp/header.html"); ?>

    <div class="title">架空サービス(退会確認）</div>    
    <?php
        // セッション開始
        @session_start();
        if (isset($_SESSION['user_id'])) {
        }elseif (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            //認証完了していない場合、index.phpを表示
            //ログイン無しアクセスを防ぐ
        }
    ?>

<?php if (isset($_SESSION['user_id'])) {?>
    <div class="comment">ログイン中Id(e-mail):<?php echo $_SESSION['user_id']; ?></div>
    <div class="comment">注意書き</div>
    <div class="comment_attention">
        <ul class="attention">
            <li>・退会した場合でも、該当ID(e-mail)で投稿した投稿、コメントは残ります。</li>
            <li>・再登録時、一度退会処理を行ったID(e-mail)でも登録できますので、退会された後も、またのご利用お待ちしております。</li>
        </ul>
    </div>
        <ul>
            <form action="/team_development/unsubscribe_processing.php" method="post">
                <input type="hidden" name="id" value=<?php echo $_SESSION['user_id']; ?>>
                <input type="submit" value="退会処理実行">
            </form>
            <BR>
            <li><a href="thread_list.php">投稿一覧に戻る</a></li>
        </ul>
<?php } //if (isset($_SESSION['user_id'])) ?>

<?php require(dirname(__FILE__) ."/temp/footer.html"); ?>
