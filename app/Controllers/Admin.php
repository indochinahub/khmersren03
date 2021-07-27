<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\StatisticModel;
use App\Models\DateTimeModel;
use App\Models\CardgroupModel;


class Admin extends MyController
{

    public function dashboard(){

        $data["page_title"] = 	"แดชบอร์ดผู้ดูแล";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];		
        $this->_view("dashboard",$data);        
    }

    public function manageCardgroup(){

        $cardgroup_model = new CardgroupModel;  
        $course_model    = new CourseModel;
        $deck_model      = new DeckModel;
        $util_moddel     = new UtilModel;
        $card_model     = new CardModel;
        
        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        } 

        $assoc_course   = $course_model->get_all_rows_as_assoc();
        $arr_deck       = $deck_model->get_all_row();
        $arr_cardgroup  = $cardgroup_model->get_all_row();

        $data["arr_cardgroup"] = [];
        foreach( $arr_cardgroup as $cardgroup){

            $cardgroup->course = $assoc_course[$cardgroup->id_course];

            $arr_deck_of_cardgroup       =   $util_moddel->get_object_from_arr_object_that_match_property_condition(
                                                    $arr_deck, 
                                                    "id_cardgroup", 
                                                    $cardgroup->cardgroup_id, 
                                                    $operator = "=="
            
                                                );
            $txt_deck = "";
            foreach( $arr_deck_of_cardgroup as $deck ){
                $txt_deck = $txt_deck.$cardgroup->course->course_code."-".$deck->deck_name.",";
            }

            $txt_deck = substr($txt_deck, 0, -1);
            $cardgroup->txt_deck = $txt_deck;

            //$cardgroup->num_card = count($card_model->get_by_cardgroup_id($cardgroup->cardgroup_id));
            $cardgroup->num_card = 55;
            

            array_push( $data["arr_cardgroup"], $cardgroup );

        }

        $data["page_title"] = 	"จัดการกลุ่มบัตรคำ"; 
        $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                    base_url(["Admin", "dashboard"])
                               ];	        
        $this->_view("manageCardgroup",$data);                


    }

    

}

