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

        $arr_card       = $this->get_by_deck_id($deck_id);
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

            if(     isset($deck->$deck_property) 
                    && ($card_property = $deck->$deck_property) 
                    && $card->$card_property)
            {

                $command = $this->get_card_value_in_html($course,$card_property,$card->$card_property);

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

        $arr_command = [];
        foreach( $arr_deck_property as $deck_property ){

            if(     isset($deck->$deck_property) 
                    && ($card_property = $deck->$deck_property) 
                    && $card->$card_property)
            {

                $command = $this->get_card_value_in_html($course,$card_property,$card->$card_property);

            }else{
                $command = false;

            }            
            array_push($arr_command, $command);
        }

        return $arr_command;
    }

    //return array of object
    public function get_card_choice($card, $course, $deck, $key_of_choices){

        $util_model = new UtilModel;

        // Convert to html
        $arr_deck_property =    [   "deck_choice1a_col", "deck_choice1b_col", "deck_choice1c_col", "deck_choice1d_col",
                                    "deck_choice2a_col", "deck_choice2b_col", "deck_choice2c_col", "deck_choice2d_col",
                                    "deck_choice3a_col", "deck_choice3b_col", "deck_choice3c_col", "deck_choice3d_col",
                                    "deck_choice4a_col", "deck_choice4b_col", "deck_choice4c_col", "deck_choice4d_col",
                                ];

        $arr_choice_html = [];
        foreach( $arr_deck_property as $deck_property ){

            if(     isset($deck->$deck_property) 
                    && ($card_property = $deck->$deck_property) 
                    && $card->$card_property
            )
            {
                $arr_choice_html[$deck_property] = $this->get_card_value_in_html($course,$card_property,$card->$card_property);

            }else{
                $arr_choice_html[$deck_property] = false;
            }
        }

        // Set Html to Object
        $obj0 = new \stdClass;
        $obj0->a = $arr_choice_html["deck_choice1a_col"];
        $obj0->b = $arr_choice_html["deck_choice1b_col"];
        $obj0->c = $arr_choice_html["deck_choice1c_col"];
        $obj0->d = $arr_choice_html["deck_choice1d_col"];
        $obj0->key = 0;

        $obj1 = new \stdClass;
        $obj1->a = $arr_choice_html["deck_choice2a_col"];
        $obj1->b = $arr_choice_html["deck_choice2b_col"];
        $obj1->c = $arr_choice_html["deck_choice2c_col"];
        $obj1->d = $arr_choice_html["deck_choice2d_col"];
        $obj1->key = 1;        

        $obj2 = new \stdClass;
        $obj2->a = $arr_choice_html["deck_choice3a_col"];
        $obj2->b = $arr_choice_html["deck_choice3b_col"];
        $obj2->c = $arr_choice_html["deck_choice3c_col"];
        $obj2->d = $arr_choice_html["deck_choice3d_col"];
        $obj2->key = 2;        

        $obj3 = new \stdClass;
        $obj3->a = $arr_choice_html["deck_choice4a_col"];
        $obj3->b = $arr_choice_html["deck_choice4b_col"];
        $obj3->c = $arr_choice_html["deck_choice4c_col"];
        $obj3->d = $arr_choice_html["deck_choice4d_col"];
        $obj3->key = 3;        
        
        $arr_choice = [ $obj0, $obj1, $obj2, $obj3 ];

        //shuffle the choice
        $arr_shuffled_choice = [];
        foreach( $key_of_choices as $key ){
            array_push( $arr_shuffled_choice, $arr_choice[$key]);
        }

        return $arr_shuffled_choice;
    }

}
