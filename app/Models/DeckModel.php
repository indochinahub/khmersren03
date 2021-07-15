<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\CardgroupModel;
use App\Models\DeckpModel;

class DeckModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "deck";
        $this->primaryKey = $this->table."_id";
    }


    // return Array Of Object
    public function get_by_cardgroup_id($cardgroup_id){

        $util_model = new UtilModel;

        $arr_deck = $this->get_all_row();
        
        $arr_deck = $util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_deck, 
                            $property_name = "id_cardgroup", 
                            $text_to_compare = $cardgroup_id, 
                            $operator = "==");

        return $arr_deck;
    }    


    // return Array Of Object
    public function get_by_course_id($course_id){

        $cardgroup_model = new CardgroupModel;
        $deck_model = new DeckModel;
        $util_model = new UtilModel;

        $arr_origin_deck = $deck_model->get_all_row();
        $arr_cardgroup = $cardgroup_model->get_by_course_id($course_id);

        $arr_deck = [];
        foreach( $arr_cardgroup as $cardgroup ){
            $arr_deck_of_cardgroup = $util_model->get_object_from_arr_object_that_match_property_condition(
                                        $origin_arr_object = $arr_origin_deck , 
                                        $property_name = "id_cardgroup", 
                                        $text_to_compare = $cardgroup->cardgroup_id, 
                                        $operator = "==");

            $arr_deck  = array_merge($arr_deck,$arr_deck_of_cardgroup);
        }

        return $arr_deck;

    }


}


