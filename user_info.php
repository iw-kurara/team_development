<?php
    define('DB_DATABASE', 'dbname');
    // define('DB_USERNAME', 'username');
    define('DB_USERNAME', 'root');
    // define('DB_PASSWORD', 'passwd');
     define('DB_PASSWORD', 'tTme');
    define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);
    // 接続
try {
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// var_dump($db);
    
//INSERT
//$db ->exec("insert into user (email,password,plan,status,start_date,update_date) values ('abc@vvv','xxx','3000','1','2019/05/02','2019/06/12')");
//echo "user added!";

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
//接続

//SESSONによるアクセス制限
if(isset($_SESSION['user_id'])){
}else{
  header('Location: index.php');
}

$sql ="SELECT * FROM user";
$stmt = $db -> prepare($sql);
$stmt->execute();

 ?>

 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>管理画面</title>
   </head>
   <body>
     <h2>管理画面</h2>
     <table border="1">
    <tr>
      <th>ID</th>
      <th>メールアドレス</th>
      <th>契約情報</th>
      <th>ステータス</th>
      <th>作成日時</th>
      <th>更新日時</th>
    </tr>

    <?php foreach ($stmt as $row) : ?>
    <tr>
      <td><?php echo $row['no'] ; ?></td>
      <td><?php echo $row['email'] ; ?></td>
      <td>
        <?php if($row['plan'] == 1000){ ?>
          <?php echo "￥1,000/月" ;?>
        <?php }elseif($row['plan'] == 3000){ ?>
          <?php echo "￥3,000/月" ;?>
        <?php }elseif($row['plan'] == 5000) {?>
          <?php echo "￥5,000/月" ;?>
        <?php }elseif($row['plan'] == 1) {?>
          <?php echo "管理者" ;?>
        <?php } ?>
      </td><!--if文でプラン条件分岐する-->
      <td>
        <?php if ($row['status'] == 0) { ?>
          <?php $span = "<span style='color:blue'>無効</span>";
          echo $span;?>
        <?php }else{ ?>
          <?php $span = "<span style='color:red'>有効</span>";
          echo $span;?>
        <?php } ?>
      </td>
      <td><?php echo $row['start_date'] ; ?></td>
      <td><?php echo $row['update_date'] ; ?></td>
    </tr>
    <?php endforeach ; ?>

  </table>
   </body>
 </html>
