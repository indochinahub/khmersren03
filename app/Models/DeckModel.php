<?php

namespace App\Models;

use App\Models\UtilModel;

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
    /*

    
        $this->load->model("cardgroup_model");
        $cardgroups = $this->cardgroup_model->get_by_course_id((int)$course_id);

        $decks = [];
        foreach($cardgroups as $cardgroup){
            
            $decks_in_cardgroup = $this->get_by_cardgroup_id($cardgroup->cardgroup_id);
            foreach($decks_in_cardgroup as $deck){
                array_push($decks,$deck);
            }
        }

        return $decks;
    
    */

        
    }


}


