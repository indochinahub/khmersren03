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

        $util_model = new UtilModel();

        $arr_cardgroup = $this->get_all_row();

        $arr_cardgroup = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_cardgroup, 
                                    $property_name = "id_course", 
                                    $text_to_compare = $course_id, 
                                    $operator = "==");

        return $arr_cardgroup;



    }


}


