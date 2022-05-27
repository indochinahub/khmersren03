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

    // return array of object
    public function get_by_user_id($user_id){

        $util_model = new UtilModel;

        $sql = " SELECT DISTINCT id_deck FROM practice WHERE id_user = $user_id " ;
        $query = $this->query($sql); 
        $arr_practice = $query->getResult();

        $arr_deck_id = $util_model->get_property_value_Of_many_objects_as_array(
                            $array_of_objects = $arr_practice,
                            $property = "id_deck"
                        );
        $arr_deck = $this->get_by_ids( $arr_deck_id );

        return $arr_deck;

    }


}


