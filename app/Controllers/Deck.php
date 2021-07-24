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

        $deck_model     = new DeckModel;
        $card_model     = new CardModel;
        $practice_model = new PracticeModel;
        $util_model     = new UtilModel;
        $course_model   = new CourseModel;


        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"] = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);

        $data["next_card_id"] = $card_model->get_next_card_id(
                                                $deck_id, 
                                                $data["user"]->user_id, 
                                                time());

        /*******************************************************/
        // Statistic Section
        /*******************************************************/
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
        $data["avarage_card_interval"] = $practice_model->get_average_interval(
                                            $deck_id,
                                            $data["user"]->user_id
                                        );
        $data["sum_visit_time"] = $practice_model->get_sum_visit_time(
                                        $deck_id, 
                                        $data["user"]->user_id
                                    );

        $data["page_title"] = 	"ชุตบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name; 
        $data["page_link"] 	= 	[	"วิชา ".$data["course"]->course_code,
                                    base_url( ["Course","show", $data["course"]->course_id] )
                               ];	        
        $this->_view("show",$data);        
    }

    public function showAllCard($deck_id){

        $card_model     = new CardModel;
        $deck_model     = new DeckModel;
        $course_model   = new CourseModel;

        $pager = service('pager');

        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"] = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);
        $data["arr_card"] = $card_model->get_by_deck_id($deck_id);

        $data["page_title"] = 	"บัตรคำทั้งหมดในชุด ".$data["course"]->course_code."-".$data["deck"]->deck_name; 
        $data["page_link"] 	= 	[   "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name,
                                    base_url(["Deck","show", $deck_id])
                               ];
                               
        $this->_view("showAllCard",$data);        
    }


}

