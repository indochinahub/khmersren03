<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;

class PracticeModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "practice";
        $this->primaryKey = $this->table."_id";
    }

    //return array of ojbect or blank array
    public function get_by_deck_id_user_id($deck_id, $user_id){
        $util_model = new UtilModel();

        $arr_practice = $this->get_all_row();

        // Filter by deck_id
        $arr_practice = $util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_practice, 
                            $property_name = "id_deck", 
                            $text_to_compare = $deck_id, 
                            $operator = "==" );

        // Filter by user_id
        $arr_practice = $util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_practice, 
                            $property_name = "id_user", 
                            $text_to_compare = $user_id, 
                            $operator = "==" );
    
        return $arr_practice;
    }

}


