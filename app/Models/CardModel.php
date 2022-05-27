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

    // return int
    public function get_num_by_cardgroup_id($cardgroup_id){

        $sql =  " SELECT COUNT(card_id) AS num_card FROM card ";
        $sql .= " WHERE id_cardgroup = $cardgroup_id ";

        $query = $this->query($sql);

        if( $result = $query->getResult() ){
            return (int) $result[0]->num_card;

        }else{
            return 0;
        }
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

    // return id int or false
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

    // return id int or false
    public function get_new_card_id_to_learn($deck_id, $user_id, $unix_timestamp){

        $util_model = new UtilModel;
        $practice_model = new PracticeModel;

        $arr_card   = $this->get_by_deck_id($deck_id);
        $arr_card   = $util_model->sort_array_of_object_by_the_property( 
                                    $arr_card, 
                                    "card_sort", 
                                    $order_by ="asc"
                                    );
        $arr_card_id    = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_card,
                                    "card_id"
                                    );

        $arr_practice = $practice_model->get_by_deck_id_user_id($deck_id, $user_id);
        $arr_learned_card_id = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_practice,
                                    "id_card"
                                    );

        if( $new_card_ids = array_values(array_diff($arr_card_id,$arr_learned_card_id))){
            return (int)$new_card_ids[0];

        }else{
            return false;

        }

    }

    // return int of false
    public function get_next_card_id($deck_id, $user_id, $unix_timestamp){

        if( $next_card_id = $this->get_next_card_id_to_review($deck_id,$user_id,  $unix_timestamp) ){
        }elseif( $next_card_id = $this->get_new_card_id_to_learn($deck_id, $user_id, $unix_timestamp) ) {
        }else{
            $next_card_id = false;
        }

        return $next_card_id;
    }

    //return html text
    public function get_card_value_in_html($course,$card_property,$card_value){

        $html = false;
        if( "card_text" == substr($card_property, 0, 9) ){
            $html = $card_value;

        }elseif( "card_youtube" == substr($card_property, 0, 12) ){
            $html = "<div class='embed-responsive embed-responsive-16by9'>";
            $html .= "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$card_value."' allowfullscreen></iframe>";
            $html .= "</div>";

        }elseif( "card_sound" == substr( $card_property, 0, 10) ){
            $url     =  base_url(["asset","course",$course->course_code,"sound",$card_value]);
                        
            $html    =  "<audio controls>";
            $html   .=  "<source src='$url' type='audio/mpeg'>";
            $html   .=  "</audio>";
            $html   .=  "<br><a href='$url'>[ Listen Directly ]</a>";

        }elseif( "card_picture" == substr( $card_property, 0, 12)){
            
            $full_pathname = ASSETPATH."course/".$course->course_code."/image/".$card_value;

            if( file_exists ($full_pathname)){
                $url  =  base_url(["asset","course",$course->course_code,"image",$card_value]);

                $html = "<div>";
                $html .= "<img src='$url' class='img-fluid'>";
                $html .= "</div>";

            }else{
                $html = "<div>Picture is not found : $full_pathname </div>";

            }                            

        }else{
            $html = false;
        }

        return $html;
    }

    //return array of object
    public function get_card_command($card, $course, $deck){

        $arr_deck_property =    [   "deck_command1_col",
                                    "deck_command2_col",
                                    "deck_command3_col",
                                    "deck_command4_col",
                                ];

        $arr_command = [];
        foreach( $arr_deck_property as $deck_property ){
            $command = new \stdClass;

            if(     isset($deck->$deck_property) 
                    && ($card_property = $deck->$deck_property) 
                    && $card->$card_property)
            {

                $command->html          = nl2br($this->get_card_value_in_html($course,$card_property,$card->$card_property));
                $command->value         = $card->$card_property;
                $command->column_name   = $card_property;


            }else{
                $command = false;

            }            
            array_push($arr_command, $command);
        }

        return $arr_command;
    }


    //return array of object
    public function get_card_answer($card, $course, $deck){

        $arr_deck_property =    [
                                       	"deck_answer1_col",
                                        "deck_answer2_col",
                                        "deck_answer3_col"
                                ];

        $arr_answer = [];
        foreach( $arr_deck_property as $deck_property ){
            $answer = new \stdClass;

            if(     isset($deck->$deck_property) 
                    && ($card_property = $deck->$deck_property) 
                    && $card->$card_property)
            {

                $answer->html           = nl2br($this->get_card_value_in_html($course,$card_property,$card->$card_property));
                $answer->value          = $card->$card_property;      
                $answer->column_name    = $card_property;

            }else{
                $answer = false;

            }            
            array_push($arr_answer, $answer);
        }

        return $arr_answer;
    }

    //return array of object
    public function get_card_choice($card, $course, $deck, $key_of_choices){

        $util_model = new UtilModel;

        $arr_choice_key = ["1","2","3","4"];
        $arr_sub_choice_key = ["a","b","c","d"];

        $arr_choice = [];
        foreach( $arr_choice_key as $choice_key ){
            $obj_choice = new \stdClass;

            foreach( $arr_sub_choice_key as $sub_choice_key){
                $obj_choice->$sub_choice_key = new \stdClass;

                $deck_property = "deck_choice".$choice_key.$sub_choice_key."_col";

                if(  isset($deck->$deck_property) 
                     && ($card_property = $deck->$deck_property) 
                     && $card->$card_property
                )
                {
                    $obj_choice->$sub_choice_key->html = nl2br($this->get_card_value_in_html($course,$card_property,$card->$card_property));
                    $obj_choice->$sub_choice_key->value = $card->$card_property;
                    $obj_choice->$sub_choice_key->column_name = $card_property;

                }else{
                    $obj_choice->$sub_choice_key = false;
                }
            }
            
            $obj_choice->key = $choice_key - 1;
            array_push($arr_choice, $obj_choice);
        }

        //shuffle the choice
        $arr_shuffled_choice = [];
        foreach( $key_of_choices as $key ){
            array_push( $arr_shuffled_choice, $arr_choice[$key]);
        }

        return $arr_shuffled_choice;
    }

    //return insertedId
    public function insert_blank_card(){

        $sql = " INSERT INTO card (id_cardgroup) VALUES (8) ";
        $query = $this->query($sql);
        return $this->db->insertID();
    }    

}
