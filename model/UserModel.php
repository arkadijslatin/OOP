<?php

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;
use core\DBDriver;

class UserModel extends BaseModel
{
    public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
    {
    	parent::__construct($db, $validator);
        $this->table = 'users';
        $this->validator -> setSchema([ // Описываем таблицу из базы данных

        	/*'id_message' => [ // Первое поле. Описываем свойства первого поля.
        		'type' => 'int', // Тип 
        		//'require' => false // Обязательно ли передавать поле в валидатор. Не обязательно т.к. оно автоинкреминтируется.
        	],

        	'dt' => [ // Второе поле
        		'type' => 'timestamp',
        		'require' =>false
        	],*/

        	'login' => [
        		'type' => 'string',
        		'length' => [3, 20],
        		'require' => true
        	],

        	'password' => [
        		'type' => 'string',
        		'length' => [3, 64], 
        		'require' => true
        	]

        	]);
        
    }
    public function getByLogin($login) // Создаем метод для вызова из таблицы users всех пользователей
    {
        
               
        return $this->db->Query(
                "SELECT * FROM {$this->table} WHERE login = :login",
                ['login' => $login],
                DBDriver::FETCH_ONE // Передаем константу для вызова одной записи из БД.
            );

    }

    public function getBySID($sid)
    {
        return $this->db->query( // Запрос в БД к таблицам users и session. JOIN - оператор склеивания таблиц. Оператор ON указывает по каким полям будем склеивать таблицу. {$this->table}.user_id - это таблица 'users' с колонкой user_id. session.user_id это таблица 'session' с колонкой user_id. WHERE - фильтруем, session.sid - выбираем из таблицы 'session' в колонке sid только ту строку где sid равен
                "SELECT * FROM {$this->table} JOIN session ON {$this->table}.user_id = session.user_id WHERE session.sid = :sid",
                ['sid' => $sid],
                DBDriver::FETCH_ONE
            );
    }

   
}