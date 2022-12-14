<?php

namespace App\Models;

class CourseTypeModel extends MyModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table      = "coursetype";
        $this->primaryKey = $this->table . "_id";
    }
}
