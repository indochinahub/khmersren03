<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DateTimeModel;
use \App\Models\UtilModel;
use \App\Models\CardcommentModel;
use \App\Models\PaginationModel;

class Cardcomment extends MyController
{
    public function showAll(){

        $cardcomment_model  = new CardcommentModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $deck_model         = new DeckModel;
        $course_model       = new CourseModel;
        $card_model         = new CardModel;
        $user_model         = new UserModel;
        $datetime_model     = new DateTimeModel;
        
        $assoc_deck     =  $deck_model->get_all_rows_as_assoc();
        $assoc_card     =  $card_model->get_all_rows_as_assoc();
        $assoc_user      =  $user_model->get_all_rows_as_assoc();


        $arr_cardcomment = $cardcomment_model->get_all_row();
        $arr_cardcomment = $util_model->sort_array_of_object_by_the_property( 
                                    $arr_cardcomment, 
                                    "cardcomment_id", 
                                    $order_by ="desc"
                                );

        if( ! ($page = $this->request->getGet('page')) ){
            $page = 1;
        }

        $pagination = $pagination_model->get_pagination( 
                                        $arr_cardcomment, 
                                        $current_page = $page , 
                                        $per_page = 20
                                    );
        $data["pagination_link"] = $pagination->link;
        $arr_cardcomment = $pagination->arr_row; 
        
        $data["arr_cardcomment"] = [];
        foreach( $arr_cardcomment as $cardcomment){

            $cardcomment->course                = $course_model->get_by_deck_id($cardcomment->id_deck);
            $cardcomment->deck                  = $assoc_deck[$cardcomment->id_deck];
            $cardcomment->card                  = $assoc_card[$cardcomment->id_card];
            $cardcomment->user                  = $assoc_user[$cardcomment->id_user];
            $cardcomment->user->display_name    = $this->user_model->get_user_displayname($cardcomment->user);
            $cardcomment->visited_time          = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                                            $cardcomment->cardcomment_createtime
                                                        );
            array_push($data["arr_cardcomment"], $cardcomment);

        }

        $data["page_title"] = 	"ความเห็นต่อบัตรคำทั้งหมด";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];	        
        $this->_view("showAll",$data);

    }
}

