<?php

 $before_name = $_COOKIE["user_name"];

 /***** $before_name, $before_comment �̎擾*****/

 $dsn = '�f�[�^�x�[�X��';//DB��Mysql�A�f�[�^�x�[�X�����w��B

 $user = '���[�U�[��';//DB�ɐڑ����邽�߂̃��[�U�[����ݒ�
 $ds_password = '�p�X���[�h';//DB�ɐڑ����邽�߂̃p�X���[�h��ݒ�

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

 if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {

          //�p�X���[�h�擾

          $pdo = new PDO($dsn, $user, $ds_password);//�f�[�^�[�x�[�X�ɐڑ�

          $result = $pdo->query('SET NAMES sjis'); //���������΍�

          $sql = "SELECT * FROM comments where id=$edit_num";

          $result = $pdo->query($sql);//���s�E���ʎ擾

          foreach ($result as $row) { $right_pass = htmlspecialchars($row['pass']); }

          if ( $edit_pass == $right_pass ) {

                    $result = $pdo->query($sql);//���s�E���ʎ擾

                    foreach ($result as $row) {

                              $before_name = htmlspecialchars($row['name']);

                              $before_comment = htmlspecialchars($row['comment']);

                    }

          }

          $pdo = null;//�ڑ��I��

 }

?>
<!DOCTYPE html>
 <html lang = "ja">

 <head>
 <meta charset = "UFT-8">
 <title>�f������낤�I�I</title>
 </head>

 <body>
 <h1>�f������낤�I�I</h1>

 <h2>�R�����g�t�H�[��</h2>

 <?php 

 if (!empty($before_comment)) {

          echo "���e�ԍ�{ <font color='red' >".htmlspecialchars($_POST['edit_num'])."</font> }��ҏW���܂�"."<br>";

          echo "���O��R�����g��ҏW������A{<font color='red' >���e�{�^��</font>}�������Ă�������"."<br>";

 }

 ?>

 <form action = "mission_2-15.php" method = "post">

 <p>���O:<input type = "text" name = "name" value = "<?=$before_name;?>" >
 �p�X���[�h:<input type = "password" name = "pass" ></p>
 <p>�R�����g:</p>
 <p><textarea name="comment" cols="50" rows="5"><?=$before_comment;?></textarea>

 <input type = "hidden" name = "edit_number" value = "<?=htmlspecialchars($_POST['edit_num']);?>" >

 <?php 

 if (empty($before_comment)) { echo "<input type = 'submit' name = 'submit' value ='���e'>"; }
 
 else { echo "<input type = 'submit' name = 'again_submit' value ='���e'>"; }

 ?>

 </p>

 </form>

 <h2>�폜�t�H�[��</h2>

 <form action = "mission_2-15.php" method = "post">

 <p>�폜�Ώ۔ԍ�:<input type = "text" name = "delete_num" size ="5" >
 �p�X���[�h:<input type = "password" name = "delete_pass">

 <input type = "submit" name = "delete" value ="�폜"></p>

 </form>

 <h2>�ҏW�t�H�[��</h2>

 <form action = "mission_2-15.php" method = "post">

 <p>�ҏW�Ώ۔ԍ�:<input type = "text" name = "edit_num" size ="5" >
 �p�X���[�h:<input type = "password" name = "edit_pass">

 <input type = "submit" name = "edit" value ="�ҏW"></p>

 </form>

 </body>

</html>

<?php

 $dsn = 'mysql:dbname=co_412_it_3919_com;host=localhost';//DB��Mysql�A�f�[�^�x�[�X�����w��B

 $user = 'co-412.it.3919.com';//DB�ɐڑ����邽�߂̃��[�U�[����ݒ�
 $ds_password = 'JhgVg6Cxy';//DB�ɐڑ����邽�߂̃p�X���[�h��ݒ�

 $name = htmlspecialchars($_POST["name"]);
 $comment = htmlspecialchars($_POST["comment"]);
 $pass = htmlspecialchars($_POST["pass"]);
 $time = date("Y/m/d H:i:s");


 /*****�R�����g�t�H�[���̃R�����g*****/

 if(isset($_POST["submit"])){

          if(empty($name)){ echo "<font color='red' >���O������܂���</font>"."<br>"; }

          if(empty($comment)) { echo "<font color='red' >�R�����g������܂���</font>"."<br>"; }

          if(empty($pass)) { echo "<font color='red' >�p�X���[�h������܂���</font>"."<br>"; }

 }


 /*****"comments"�Ƀf�[�^��}��*****/

 if(isset($_POST["submit"])){

          if( (!empty($name)) && (!empty($comment)) && (!empty($pass)) ) {

                    $pdo = new PDO($dsn, $user, $ds_password);//�f�[�^�[�x�[�X�ɐڑ�

                    $sql = $pdo->query('SET NAMES sjis'); //���������΍�

                    //INSERT�Ńf�[�^�}��

                    $sql = $pdo -> prepare("INSERT INTO comments(name,comment,time,pass) VALUES(:name, :comment, :time, :pass)");

                    $sql->bindParam(':name', $name, PDO::PARAM_STR);
                    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql->bindParam(':time', $time, PDO::PARAM_STR);
                    $sql->bindParam(':pass', $pass, PDO::PARAM_STR);

                    $sql-> execute();

                    $pdo = null;//�ڑ��I��

          }

 }


/*****�폜�t�H�[���̃R�����g*****/

 $delete_num = htmlspecialchars($_POST["delete_num"]);
 $delete_pass = htmlspecialchars($_POST["delete_pass"]);

 if(isset($_POST["delete"])){

          if (empty($delete_num)) { echo "<font color='red' >�폜�Ώ۔ԍ�������܂���</font>"."<br>"; }

          if (empty($delete_pass)) { echo "<font color='red' >�p�X���[�h������܂���</font>"."<br>"; }

 }


 /*****�폜�@�\*****/

 if( (isset($_POST["delete"])) && (!empty($delete_num)) ){

          //�p�X���[�h�擾

          $pdo = new PDO($dsn, $user, $ds_password);//�f�[�^�[�x�[�X�ɐڑ�

          $result = $pdo->query('SET NAMES sjis'); //���������΍�

          $sql = "SELECT * FROM comments where id=$delete_num";

          $result = $pdo->query($sql);//���s�E���ʎ擾

          foreach ($result as $row) {

                    $right_pass = htmlspecialchars($row['pass']);

          }

          if ( $delete_pass==$right_pass ) {

                    $sql = "delete from comments where id=$delete_num";

                    $result = $pdo->query($sql);//���s�E���ʎ擾

          }

          else { echo "<font color='red' >�p�X���[�h���Ⴂ�܂�</font>"."<br>"; }

          $pdo = null;//�ڑ��I��

 }


 /*****�ҏW�t�H�[���̃R�����g*****/

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

 if(isset($_POST["edit"])){

          if (empty($edit_num)) { echo "<font color='red' >�ҏW�Ώ۔ԍ�������܂���</font>"."<br>"; }

          if(empty($edit_pass)) { echo "<font color='red' >�p�X���[�h������܂���</font>"."<br>"; }

          else if(empty($before_comment)) { echo "<font color='red' >�p�X���[�h���Ⴂ�܂�</font>"."<br>"; }

 }


 /*****�ҏW�@�\*****/

 if(isset($_POST["again_submit"])){

          $edit_name = htmlspecialchars($_POST["name"]);
          $edit_comment = htmlspecialchars($_POST["comment"]);

          $edit_number = htmlspecialchars($_POST["edit_number"]);

          if ( (!empty($edit_name)) && (!empty($edit_comment)) ) {

                    $pdo = new PDO($dsn, $user, $ds_password);//�f�[�^�[�x�[�X�ɐڑ�

                    $result = $pdo->query('SET NAMES sjis'); //���������΍�

                    $sql = "update comments set name='$edit_name', comment='$edit_comment', time ='$time', edit_mode='(�ҏW�ς�)' where id=$edit_number ";

                    $result = $pdo->query($sql);//���s�E���ʎ擾

                    $pdo = null;//�ڑ��I��

          }

 }


 /*****�e�[�u��"comments"�̕\��*****/

 echo "<br>";

 echo "********************�R�����g�ꗗ********************"."<br>"."<br>";

 $pdo = new PDO($dsn, $user, $ds_password);//�f�[�^�[�x�[�X�ɐڑ�

 $result = $pdo->query('SET NAMES sjis'); //���������΍�

 $sql = "SELECT * FROM comments ORDER BY id";//�N�G��

 $result = $pdo->query($sql);//���s�E���ʎ擾

 foreach ($result as $row) {

          echo htmlspecialchars($row['id']).": ";
          echo htmlspecialchars($row['name']).": ";
          echo htmlspecialchars($row['time'])."; ";
          echo htmlspecialchars($row['edit_mode'])."<br>";
          echo "<font color= 'Impact' >".nl2br(htmlspecialchars($row['comment']))."</font>"."<br>"."<br>";

 }

 $pdo = null;//�ڑ��I��

?>