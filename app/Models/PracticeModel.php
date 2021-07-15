<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\DateTimeModel;

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

    // return array of object
    public function get_to_review($deck_id, $user_id, $unix_timestamp, $next_day){

        $datetime_model = new DateTimeModel();
        $util_model = new UtilModel();

        $unix_timestamp = $datetime_model->get_unix_timestamp($unix_timestamp, $next_day);
        $sql_time_stamp = $datetime_model->unix_timestamp_to_sql_timestamp($unix_timestamp);

        $arr_practice = $this->get_by_deck_id_user_id($deck_id, $user_id);

        // filter by date
        $arr_practice = $util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_practice, 
                            $property_name = "practice_nextVisitDate", 
                            $text_to_compare = $sql_time_stamp, 
                            $operator = "<"
                        ); 

        // Sort
        $arr_practice = $util_model->sort_array_of_object_by_the_property( 
                            $objects = $arr_practice, 
                            $sorted_property = "practice_intervalDay", 
                            $order_by ="desc");

        return $arr_practice;

    }

}


