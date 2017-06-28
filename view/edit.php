<div class="edit">

	<?foreach($message as $messages):?>
		<? $name = $messages['name'];?>
		<? $text = $messages['text'];?>
     <?endforeach?>

	<form action="" method="post">
	    <span>Имя статьи</span><br><br>
	    <input type="text" name="name" value="<?= $name ; ?>" class="input_title" ><br><br>
	    <span>Текст статьи</span><br><br>
	    <textarea name="text" rows="11" cols="68" class="input_content"><?= $text; ?></textarea><br><br>
		<input type="submit" name="edit" value="Редактировать">&emsp;
	    <input type="submit" name="delete" value="Удалить">
	</form>
</div>
<div class="msg">
	<a href="/post/">На главную</a><br><br>
	<p><?= $msg?></p>
</div>

