<div class="article">
    <ul>
        <?foreach($messages as $message):
                $id = $message['id_message']; 
                $title = $message['name']; 
                $dt = $message['dt']; ?>
            <li>            
                <p>Статья &nbsp;- </p> &nbsp;
                <p><?="$title" ?></p><br>
                <h4><?= date('H:i d/m/Y', strtotime($message['dt'])) ?></h4>
                <a href="/post/one/<?php echo $id ?>">читать</a>
            </li>  <br>          
        <?endforeach?>
    </ul> 
    <h2><?= $article; ?></h2>
   
    <? if ($this->entrance): ?>
    
    <a href="/post/add" >Добавить</a> &nbsp;
    <? endif ?>
</div> 






   
        
        
   


           
       