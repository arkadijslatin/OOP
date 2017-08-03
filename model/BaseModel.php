<?php

namespace model;

namespace model;

use core\DBDriverInterface;
use core\DBDriver;
use core\exception\ModelException;
use core\Logger;
use controller\BaseController;
use core\Request;
use core\ValidatorInterface;
use core\exception\ValidatorException;

abstract class BaseModel
{
    protected $db;
    protected $validator;
    protected $table = false;
    
    public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
    {
        $this->db = $db;
        $this->validator = $validator;
        try {
            if ($this->table) {
                throw new ModelException('Table name is not defined.');  
            }
        } catch (ModelException $e) {
            $logger = new Logger ('critical', LOG_DIR);
            $logger->write(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()), Logger::ERR);


           /* $ctrl = new BaseController($this->request); Почему то не может создать объект класса BaseController
            $ctrl->staticAction('Table name is not defined.');
            $ctrl->response();*/
            
        }
    }

    public function getAll()
    {
        return $this->db->Query("SELECT * FROM {$this->table} ORDER BY dt DESC");
    }

    public function getOne($id)
    {
        
        return $this->db->Query("SELECT * FROM {$this->table} WHERE id_message=$id",$obj = [], DBDriver::FETCH_ONE); // Если передаем не один аргумент - запрос, то необходимо передавать столько аргументов, сколько прописано при создании метода.
    }

    public function insert($obj) // $obj - это массив состоящий из полей которые заполняем при добавлении статьи.

    {


        $this->validator->run($obj); //
        if (!empty($this->validator->errors)) { // Если возникли ошибки при исполнении метода run($obj)
          
            throw new ValidatorException($this->validator->errors); // То выбрасываем исключение с массивом в который записаны ошибки ($this->validator->errors)
        }

        return $this->db->Insert($this->table, $this->validator->clean); // Добавляем в базу данных данные которые заполнили в форме. $this->table - название таблицы в БД, $this->validator->clean - провалидированный массив для передачи в БД.
    }

    public function edit($id, $obj)
    {
        $this->validator->run($obj);

        if (!empty($this->validator->errors)) {
            
            throw new ValidatorException($this->validator->errors);
        }
        
        return $this->db->Update($this->table, $this->validator->clean, $id);
    }

    public function delete($id)
     {
       
        return $this->db->Delete($this->table, $id);    
    }
    

}