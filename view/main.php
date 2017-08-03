<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title?></title>
    <base href="/">
    <link rel="stylesheet" href="css/style.css">
</head>
  <body>
    <div class="head">
      <div class="name">
         <h3>Здравствуйте <span><?= $this->forename?></span></h3>
      </div>
      <div class="registration">
        <a href="/user/login">Войти /</a> 
        <a href="/user/reg">Зарегистрироваться</a>
      </div>
      <h1>Мой блог на php</h1>

    </div>
    <div class="content">
      <?= $content?>
      

    </div>
    
  </body>
</html>