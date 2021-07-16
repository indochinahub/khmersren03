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

        $where_clause = " WHERE id_cardgroup = ".$cardgroup_id ;
        return $this->get_where($where_clause);
    }    


    // return Array Of Object
    public function get_by_course_id($course_id){

        $cardgroup_model = new CardgroupModel;

        $arr_cardgroup = $cardgroup_model->get_by_course_id($course_id);

        $arr_deck = [];
        foreach($arr_cardgroup as $cardgroup){
            $arr_deck_of_cardgroup = $this->get_by_cardgroup_id($cardgroup->cardgroup_id);
            $arr_deck = array_merge($arr_deck, $arr_deck_of_cardgroup);
            
        }

        return $arr_deck;

    }


}


