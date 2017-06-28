<div class="post">
	
	<?foreach($messages as $message):
                $id = $message['id_message']; 
                $dt = $message['dt']; ?>
     <?endforeach?>
	<h2><?=($message['name']); ?></h2>
	<textarea name="content" rows="14" cols="68" class="input_content"><?= ($message['text']); ?></textarea><br>
	<p><?= date('H:i d/m/Y', strtotime($message['dt'])) ?></p>
	<a href="/post/">На главную</a> &nbsp;
	
	<a href="/post/edit/<?php echo $message['id_message'] ?>">Редактировать</a>
</div>