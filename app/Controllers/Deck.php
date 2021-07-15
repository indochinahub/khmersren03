<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;

class Deck extends MyController
{

    public function show($deck_id){

        $deck_model = new DeckModel;
        $card_model = new CardModel;
        $practice_model = new PracticeModel;
        $util_model = new UtilModel;

        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"] = $deck_model->get_by_id($deck_id);
        $data["num_all_card"] = count($card_model->get_by_deck_id($deck_id));

        $arr_practice = $practice_model->get_by_deck_id_user_id(
                            $deck_id, 
                            $data["user"]->user_id);

        $data["num_user_card"] = count( $arr_practice );
        $data["card_to_review_today"] = count(    $practice_model->get_to_review(
                                    $deck_id, 
                                    $data["user"]->user_id, 
                                    time(), 
                                    $next_day = 0 )
                            );
        $data["card_to_review_tomorrow"] = count(    $practice_model->get_to_review(
                                    $deck_id, 
                                    $data["user"]->user_id, 
                                    time(), 
                                    $next_day = 1)
                                );  
        $data["avarage_card_interval"] = (int) $util_model->get_average_property_of_arr_object( 
                                        $arr_object = $arr_practice, 
                                        $property = "practice_intervalDay"
                                    );

        $data["page_title"] = 	"ชุตบัตรคำ ";
        $data["page_link"] 	= 	[	"Home",
                                    base_url()
                                ];	        
        $this->_view("show",$data);        

    }


}

