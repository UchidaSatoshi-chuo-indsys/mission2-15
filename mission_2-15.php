<?php

 $before_name = $_COOKIE["user_name"];

 /***** $before_name, $before_comment の取得*****/

 $dsn = 'データベース名';//DBにMysql、データベース名を指定。

 $user = 'ユーザー名';//DBに接続するためのユーザー名を設定
 $ds_password = 'パスワード';//DBに接続するためのパスワードを設定

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

 if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {

          //パスワード取得

          $pdo = new PDO($dsn, $user, $ds_password);//データーベースに接続

          $result = $pdo->query('SET NAMES sjis'); //文字化け対策

          $sql = "SELECT * FROM comments where id=$edit_num";

          $result = $pdo->query($sql);//実行・結果取得

          foreach ($result as $row) { $right_pass = htmlspecialchars($row['pass']); }

          if ( $edit_pass == $right_pass ) {

                    $result = $pdo->query($sql);//実行・結果取得

                    foreach ($result as $row) {

                              $before_name = htmlspecialchars($row['name']);

                              $before_comment = htmlspecialchars($row['comment']);

                    }

          }

          $pdo = null;//接続終了

 }

?>
<!DOCTYPE html>
 <html lang = "ja">

 <head>
 <meta charset = "UFT-8">
 <title>掲示板を作ろう！！</title>
 </head>

 <body>
 <h1>掲示板を作ろう！！</h1>

 <h2>コメントフォーム</h2>

 <?php 

 if (!empty($before_comment)) {

          echo "投稿番号{ <font color='red' >".htmlspecialchars($_POST['edit_num'])."</font> }を編集します"."<br>";

          echo "名前やコメントを編集した後、{<font color='red' >投稿ボタン</font>}を押してください"."<br>";

 }

 ?>

 <form action = "mission_2-15.php" method = "post">

 <p>名前:<input type = "text" name = "name" value = "<?=$before_name;?>" >
 パスワード:<input type = "password" name = "pass" ></p>
 <p>コメント:</p>
 <p><textarea name="comment" cols="50" rows="5"><?=$before_comment;?></textarea>

 <input type = "hidden" name = "edit_number" value = "<?=htmlspecialchars($_POST['edit_num']);?>" >

 <?php 

 if (empty($before_comment)) { echo "<input type = 'submit' name = 'submit' value ='投稿'>"; }
 
 else { echo "<input type = 'submit' name = 'again_submit' value ='投稿'>"; }

 ?>

 </p>

 </form>

 <h2>削除フォーム</h2>

 <form action = "mission_2-15.php" method = "post">

 <p>削除対象番号:<input type = "text" name = "delete_num" size ="5" >
 パスワード:<input type = "password" name = "delete_pass">

 <input type = "submit" name = "delete" value ="削除"></p>

 </form>

 <h2>編集フォーム</h2>

 <form action = "mission_2-15.php" method = "post">

 <p>編集対象番号:<input type = "text" name = "edit_num" size ="5" >
 パスワード:<input type = "password" name = "edit_pass">

 <input type = "submit" name = "edit" value ="編集"></p>

 </form>

 </body>

</html>

<?php

 $dsn = 'mysql:dbname=co_412_it_3919_com;host=localhost';//DBにMysql、データベース名を指定。

 $user = 'co-412.it.3919.com';//DBに接続するためのユーザー名を設定
 $ds_password = 'JhgVg6Cxy';//DBに接続するためのパスワードを設定

 $name = htmlspecialchars($_POST["name"]);
 $comment = htmlspecialchars($_POST["comment"]);
 $pass = htmlspecialchars($_POST["pass"]);
 $time = date("Y/m/d H:i:s");


 /*****コメントフォームのコメント*****/

 if(isset($_POST["submit"])){

          if(empty($name)){ echo "<font color='red' >名前がありません</font>"."<br>"; }

          if(empty($comment)) { echo "<font color='red' >コメントがありません</font>"."<br>"; }

          if(empty($pass)) { echo "<font color='red' >パスワードがありません</font>"."<br>"; }

 }


 /*****"comments"にデータを挿入*****/

 if(isset($_POST["submit"])){

          if( (!empty($name)) && (!empty($comment)) && (!empty($pass)) ) {

                    $pdo = new PDO($dsn, $user, $ds_password);//データーベースに接続

                    $sql = $pdo->query('SET NAMES sjis'); //文字化け対策

                    //INSERTでデータ挿入

                    $sql = $pdo -> prepare("INSERT INTO comments(name,comment,time,pass) VALUES(:name, :comment, :time, :pass)");

                    $sql->bindParam(':name', $name, PDO::PARAM_STR);
                    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql->bindParam(':time', $time, PDO::PARAM_STR);
                    $sql->bindParam(':pass', $pass, PDO::PARAM_STR);

                    $sql-> execute();

                    $pdo = null;//接続終了

          }

 }


/*****削除フォームのコメント*****/

 $delete_num = htmlspecialchars($_POST["delete_num"]);
 $delete_pass = htmlspecialchars($_POST["delete_pass"]);

 if(isset($_POST["delete"])){

          if (empty($delete_num)) { echo "<font color='red' >削除対象番号がありません</font>"."<br>"; }

          if (empty($delete_pass)) { echo "<font color='red' >パスワードがありません</font>"."<br>"; }

 }


 /*****削除機能*****/

 if( (isset($_POST["delete"])) && (!empty($delete_num)) ){

          //パスワード取得

          $pdo = new PDO($dsn, $user, $ds_password);//データーベースに接続

          $result = $pdo->query('SET NAMES sjis'); //文字化け対策

          $sql = "SELECT * FROM comments where id=$delete_num";

          $result = $pdo->query($sql);//実行・結果取得

          foreach ($result as $row) {

                    $right_pass = htmlspecialchars($row['pass']);

          }

          if ( $delete_pass==$right_pass ) {

                    $sql = "delete from comments where id=$delete_num";

                    $result = $pdo->query($sql);//実行・結果取得

          }

          else { echo "<font color='red' >パスワードが違います</font>"."<br>"; }

          $pdo = null;//接続終了

 }


 /*****編集フォームのコメント*****/

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

 if(isset($_POST["edit"])){

          if (empty($edit_num)) { echo "<font color='red' >編集対象番号がありません</font>"."<br>"; }

          if(empty($edit_pass)) { echo "<font color='red' >パスワードがありません</font>"."<br>"; }

          else if(empty($before_comment)) { echo "<font color='red' >パスワードが違います</font>"."<br>"; }

 }


 /*****編集機能*****/

 if(isset($_POST["again_submit"])){

          $edit_name = htmlspecialchars($_POST["name"]);
          $edit_comment = htmlspecialchars($_POST["comment"]);

          $edit_number = htmlspecialchars($_POST["edit_number"]);

          if ( (!empty($edit_name)) && (!empty($edit_comment)) ) {

                    $pdo = new PDO($dsn, $user, $ds_password);//データーベースに接続

                    $result = $pdo->query('SET NAMES sjis'); //文字化け対策

                    $sql = "update comments set name='$edit_name', comment='$edit_comment', time ='$time', edit_mode='(編集済み)' where id=$edit_number ";

                    $result = $pdo->query($sql);//実行・結果取得

                    $pdo = null;//接続終了

          }

 }


 /*****テーブル"comments"の表示*****/

 echo "<br>";

 echo "********************コメント一覧********************"."<br>"."<br>";

 $pdo = new PDO($dsn, $user, $ds_password);//データーベースに接続

 $result = $pdo->query('SET NAMES sjis'); //文字化け対策

 $sql = "SELECT * FROM comments ORDER BY id";//クエリ

 $result = $pdo->query($sql);//実行・結果取得

 foreach ($result as $row) {

          echo htmlspecialchars($row['id']).": ";
          echo htmlspecialchars($row['name']).": ";
          echo htmlspecialchars($row['time'])."; ";
          echo htmlspecialchars($row['edit_mode'])."<br>";
          echo "<font color= 'Impact' >".nl2br(htmlspecialchars($row['comment']))."</font>"."<br>"."<br>";

 }

 $pdo = null;//接続終了

?>