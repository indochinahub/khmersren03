<?php

namespace App\Models;

class LessonModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "lesson";
        $this->primaryKey = $this->table."_id";
    }


}



