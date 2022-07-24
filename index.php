<?php
  if (!empty($_POST["submitButton"])){//empty関数＝値が空かどうかの判定。!で反転させる。
    echo $_POST["username"];//$_POSTなどはスーパーグローバル変数という
    echo $_POST["comment"];
  }

  //データベース接続
  $db = new PDO('mysql:host=localhost,dbname=bbs','root','root');
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
      <section>
        <article>
          <div class="wrapper">
            <span>名前:</span>
            <p class="username"></p>
            <time>2020/10/15</time>
          </div>
        </article>
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