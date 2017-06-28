<?php

namespace core;
class DB
{
    private static $db;

    public static function connect()
    {
        if($db == null){
            $db = new \PDO('mysql:host=localhost; dbname=phpchat1', 'root', ''); 
            $db->exec("SET NAMES UTF8");
        }
        
        return $db;
    }
}

   