<?php

namespace model;

namespace model;

use core\DBDriverInterface;

abstract class BaseModel
{
    protected $db;
    protected $table;
    
    public function __construct(DBDriverInterface $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->Query("SELECT * FROM {$this->table} ORDER BY dt DESC");
    }

    public function getOne($id)
    {
        
        return $this->db->Query("SELECT * FROM {$this->table} WHERE id_message=$id");
    }

    public function insert($obj)

    {

        return $this->db->Insert($this->table, $obj);
    }

    public function edit($id, $obj)
    {
        
        return $this->db->Update($this->table, $obj, $id);
    }

    public function delete($id)
     {
       
        return $this->db->Delete($this->table, $id);    
    }
    

}