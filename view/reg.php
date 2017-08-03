<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?= $title?></title>
</head>
<body>
	<div class="reg">
		<form action="" method="post">
		    <span>Логин</span><br><br>
		    <input type="text" name="login" value="<?= isset($post ['login']) ? $post ['login']: ''?>" class="input_title" ><?= $login; ?><br><br>
		    <span>Пароль</span><br><br>
		    <input type="text" name="password" value="<?= isset($post ['password']) ? $post ['password']: ''?>" class="input_title" ><br><br>
		     

		    <input type="submit" value="Зарегистрироваться"><br><br>
		</form>
	</div>
	
	<div class="msg">

		
		<a href="/post/">На главную</a><br><br>
		<p><?= $msg?></p>
		<?foreach($errors as $error): ?>
		<?endforeach?>
     	<p><?= $error?></p>
		
	</div>
</body>
</html>