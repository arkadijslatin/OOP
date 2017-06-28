<?php

namespace model;

use core\DBDriverInterface;

class PostModel extends BaseModel
{
    public function __construct(DBDriverInterface $db)
    {
        $this->table = 'messages';
        parent::__construct($db);
    }

   
}