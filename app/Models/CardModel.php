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

        $where_clause = " WHERE id_cardgroup = ".$cardgroup_id;
        return $this->get_where($where_clause);

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

    // return id int
    public function get_next_card_id_to_review($deck_id, $user_id, $unix_timestamp){
        $practice_model = new PracticeModel;

        $arr_practice = $practice_model->get_to_review(
                                                            $deck_id, 
                                                            $user_id, 
                                                            $unix_timestamp, 
                                                            $next_day = 0);
        if( $arr_practice ){
            return (int) $arr_practice[0]->id_card;
        }else{
            return false;
        }
    }

    // return id int
    public function get_new_card_id_to_learn($deck_id, $user_id, $unix_timestamp){

        $util_model = new UtilModel;
        $practice_model = new PracticeModel;

        $arr_card       = $this->get_by_deck_id($deck_id);
        $arr_card_id    = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_card,
                                    "card_id"
                                );

        echo "\n";
        echo $this->db->getLastQuery();
        echo "\n";
                        
        $arr_practice = $practice_model->get_to_review(
                                $deck_id, 
                                $user_id, 
                                $unix_timestamp, 
                                $next_day = 0
                            );

        echo "\n";
        echo $this->db->getLastQuery();
        echo "\n";
        

        $arr_learned_card_id    = $util_model->get_property_value_Of_many_objects_as_array(
                                $arr_practice,
                                "id_card"
                            );

                            
        /*                            
        if( $arr_new_card_id = array_values(array_diff($arr_card_id,$arr_learned_card_id))){
            echo "\n";
            var_dump($arr_new_card_id);
            echo "\n";                            
            return (int)$arr_new_card_id[0];
        }else{
            return FALSE;
        } 
        */       

    /*
        $this->load->model("practice_model");

        $all_card_ids = $this->get_card_ids_by_deck_id($deck_id);

        $practices = $this->practice_model->get_by_deck_id_and_user_id($deck_id, $user_id);

        $practiced_card_ids = $this->util_model->get_property_value_Of_many_objects_as_array($array_of_objects = $practices, $property = "id_card");

        if( $new_card_ids = array_values(array_diff($all_card_ids,$practiced_card_ids))){
            return (int)$new_card_ids[0];
        }else{
            return FALSE;
        }    
    */

    }

            


}


