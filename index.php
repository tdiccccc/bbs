<?php
  date_default_timezone_set("Asia/Tokyo");

  $comment_array = array();
  $error_message = array();
  $db = null;
  $stmt = null;
  
  
  //データベース接続
  try {
    $db = new PDO('mysql:host=localhost;dbname=bbs','root','root');
  } catch(PDOException $e) {
    $error_message[] = $e->getMessage();
  }

  //フォームを打ち込んだ時
  if (!empty($_POST["submitButton"])){//empty関数＝値が空かどうかの判定。!で反転させる。
    
    if (empty($_POST["username"])){
      $error_message[] = "お名前を入力してください";
    } else {
      $escaped['username'] = htmlspecialchars($_POST["username"],ENT_QUOTES,"UTF-8");
    }

    if (empty($_POST["comment"])){
      $error_message[] = "コメントを入力してください";
    } else {
      $escaped['comment'] = htmlspecialchars($_POST["comment"],ENT_QUOTES,"UTF-8");
    }


    
    if (empty($error_message)) {
      $postDate = date("Y-m-d H:i:s");

      try {
        //$_POSTなどはスーパーグローバル変数という
        $stmt = $db->prepare("INSERT INTO `bbs-table` (`name`, `comment`, `postDate`) VALUES (:name, :comment, :postDate);");
        $stmt->bindParam(':name', $_POST["username"], PDO::PARAM_STR);
        $stmt->bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
        $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
        
        $stmt->execute();
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
    }
  }
  
  
  //DBからコメントデータを取得する
  $sql = "SELECT * FROM `bbs-table`;";
  $comment_array = $db->query($sql);
  
  //DBの接続を閉じる
  $db = null;
  ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BBS</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="title">PHP</h1>
  <form action="" class="formWrapper" method="POST">
    <div class="boardWrapper">
      <?php if (!empty($error_message)) : ?>
          <?php foreach ($error_message as $value) : ?>
              <div class="error_message">※<?php echo $value; ?></div>
          <?php endforeach; ?>
      <?php endif; ?>
      <section>
        <?php foreach($comment_array as $comment) : ?>
          <article>
            <div class="wrapper">
              <div class="nameArea">
                <span>名前:</span>
                <p class="username"><?php echo $comment["name"]; ?></p>
                <time><?php echo $comment["postDate"] ?></time>
              </div>
            </div>
            <p class="comment"><?php echo $comment["comment"];?></p>
          </article>
        <?php endforeach; ?>
      </section>
      <div>
        <input type="submit" value="書き込む" name="submitButton">
        <label for="">名前:</label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea" name="comment"></textarea>
      </div>
    </div>
  </form>
</body>
</html>