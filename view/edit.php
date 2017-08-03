<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title?></title>
    <base href="/">
    <link rel="stylesheet" href="css/style.css">
</head>
	<body>
		<div class="edit">
			<? if (!empty($errors['name'])) :?>
					<? $msg = $errors['name'];?>
					<? elseif (!empty($errors['text'])) :?>
					<? $msg = $errors['text'];?>
			<? endif; ?>
	
	
			<form action="" method="post">
			    <span>Имя статьи</span><br><br>
			    <input type="text" name="name" value="<?= $name ; ?>" class="input_title" ><br><br>
			    <span>Текст статьи</span><br><br>
			    <textarea name="text" rows="5" cols="50" class="input_content"><?= $text; ?></textarea><br><br>
			   
				<input type="submit" name="edit" value="Редактировать">&emsp;
			    <input type="submit" name="delete" value="Удалить">
			</form>
		</div>
		<div class="msg">
			<a href="/post/">На главную</a><br><br>
			<p><?= $msg?></p>
		</div>
	</body>
</html>


