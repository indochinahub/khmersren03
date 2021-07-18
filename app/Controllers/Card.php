<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;

class Card extends MyController
{
    public function show($page, $card_id, $deck_id){

        $deck_model = new DeckModel;
        $course_model = new CourseModel;
        $card_model = new CardModel;

        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $deck   = $deck_model->get_by_id($deck_id);
        $course = $course_model->get_by_deck_id($deck_id);
        $card   = $card_model->get_by_id($card_id);
        $data["page"] = $page;

        // Command Section
        $data["arr_command"] = $card_model->get_card_command($card, $course, $deck);
        
        if( $data["page"] === "a"){
            $data["key_of_choices"] = [ 0, 1, 2, 3];
            shuffle( $data["key_of_choices"] );

        }elseif( $data["page"] === "b"){
            $arr_segment = $this->uri->getSegments();
            $data["key_of_choices"] =   [      
                                            (int)$arr_segment[5],
                                            (int)$arr_segment[6],
                                            (int)$arr_segment[7],
                                            (int)$arr_segment[8],
                                        ];
            $data["selected_choice"] =  (int) $arr_segment[9] ;
        }

        // Choice Section
        
        $data["arr_choice"] = $card_model->get_card_choice($card, $course, $deck, $data["key_of_choices"]);

        $data["deck"] = $deck;
        $data["card"] = $card;
        $data["course"] = $course;
        /*

        $data["answer1"]
        $data["answer2"]
        $data["answer3"]
        

        */

        $data["page_title"] = 	"xxxxx";
        $data["page_link"] 	= 	[ "Deck", "#"];	        
        $this->_view("show",$data);        

    }


}

