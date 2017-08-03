<?php

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;

class PostModel extends BaseModel
{
    public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
    {
    	parent::__construct($db, $validator);
        $this->table = 'messages';
        $this->validator -> setSchema([ // Описываем таблицу из базы данных

        	/*'id_message' => [ // Первое поле. Описываем свойства первого поля.
        		'type' => 'int', // Тип 
        		//'require' => false // Обязательно ли передавать поле в валидатор. Не обязательно т.к. оно автоинкреминтируется.
        	],

        	'dt' => [ // Второе поле
        		'type' => 'timestamp',
        		'require' =>false
        	],*/

        	'name' => [
        		'type' => 'string',
        		'length' => [2, 64],
        		'require' => true
        	],

        	'text' => [
        		'type' => 'string',
        		'length' => 65536, 
        		'require' => true
        	]

        	]);
        
    }

   
}