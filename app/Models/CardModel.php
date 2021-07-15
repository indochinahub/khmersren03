<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\PracticeModel;

class CardModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "card";
        $this->primaryKey = $this->table."_id";
    }

    // return array of card or blank array
    public function get_by_cardgroup_id($cardgroup_id){

        $util_model = new UtilModel();
        
        $arr_card = $this->get_all_row();
        $arr_card = $util_model->get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object = $arr_card, 
                        $property_name = "id_cardgroup", 
                        $text_to_compare = $cardgroup_id, 
                        $operator = "==" );

        return $arr_card;
    }

    // return array Of object Or blank array
    public function get_by_deck_id($deck_id){
        $deck_model = new DeckModel();

        if( $deck = $deck_model->get_by_id($deck_id) ){
            $arr_card = $this->get_by_cardgroup_id($deck->id_cardgroup);
            return $arr_card;

        }else{
            return [];
        }
    }


}


