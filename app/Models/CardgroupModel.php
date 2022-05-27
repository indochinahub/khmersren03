<?php

namespace App\Models;

use App\Models\UtilModel;

class CardgroupModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "cardgroup";
        $this->primaryKey = $this->table."_id";
    }

    // return array Of object Or blank array
    public function get_by_course_id($course_id){

        $where_clause = " WHERE id_course = ".$course_id ;
        return $this->get_where($where_clause);
    }


}


