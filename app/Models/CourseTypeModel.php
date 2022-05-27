<?php

namespace App\Models;

class CoursetypeModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "coursetype";
        $this->primaryKey = $this->table."_id";
    }

}


