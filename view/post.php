<div class="post">
	
	
	<h2><?=($message['name']); ?></h2>
	<textarea name="content" rows="10" cols="68" class="input_content"><?= ($message['text']); ?></textarea><br>
	<p><?= date('H:i d/m/Y', strtotime($message['dt'])) ?></p>
	<a href="/post/">На главную</a> &nbsp;
	<? if ($this->entrance): ?>
		<a href="/post/edit/<?php echo $message['id_message'] ?>">Редактировать</a>
	<? endif; ?>
</div>