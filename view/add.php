
<div class="add">
	<form action="" method="post">
	    <span>Имя статьи</span><br><br>
	    <input type="text" name="name" value="" class="input_title" ><?= $name; ?><br><br>
	    <span>Текст статьи</span><br><br>
	    <textarea name="text" rows="8" cols="68" class="input_content"><?= $text; ?></textarea><br><br>

	    <input type="submit" value="Добавить">
	</form>
</div>
<div class="msg">
	<a href="/post/">На главную</a><br><br>
	<p><?= $msg?></p>
</div>
    