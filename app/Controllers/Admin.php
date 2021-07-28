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
use App\Models\FileModel;


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

            $cardgroup->num_card = $card_model->get_num_by_cardgroup_id($cardgroup->cardgroup_id);
            ////$cardgroup->num_card = 55;

            array_push( $data["arr_cardgroup"], $cardgroup );

        }

        $data["page_title"] = 	"จัดการกลุ่มบัตรคำ"; 
        $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                    base_url(["Admin", "dashboard"])
                               ];	        
        $this->_view("manageCardgroup",$data);                


    }


    public function exportCardgroup($cardgroup_id, $confirm = "0"){

        $cardgroup_model= new CardgroupModel;
        $card_model     = new CardModel;
        $util_moddel    = new UtilModel;
        $file_model     = new FileModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        // Get Some Data
        $cardgroup  = $cardgroup_model->get_by_id( $cardgroup_id );
        $arr_card   = $card_model->get_by_cardgroup_id($cardgroup_id);
        $num_card   = count($card_model->get_by_cardgroup_id($cardgroup_id));
        $arr_column = $card_model->get_column();

        if( $confirm === "0" ){

            $data    =  [   "page_title"=>"ยืนยันการส่งออกชุดบัตรคำ",
                            "what_happened"=>"ท่านกำลังส่งออกชุดบัตรคำหมายเลข $cardgroup_id จำนวน $num_card ข้อ ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","exportCardgroup", $cardgroup_id, 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Admin","manageCardgroup"]),
                        ];  		

            $this->_view("confirm",$data);    

        }else{

            // Get Line of Column
            $line_column    = $util_moddel->get_line_of_text_from_array (
                                        $arr_column, 
                                        "\t" 
                                    );
            // Get text of data
            $txt_data  = "";
            foreach( $arr_card as $card ){

                $line_row = "";
                foreach( $arr_column as $column ){
                    if( $card->$column){
                        $line_row = $line_row.$card->$column."\t";
                    }else{
                        $line_row = $line_row."NULL"."\t";
                    }
                }
                $line_row = substr( $line_row,0,-1 )."\n";
                $txt_data  = $txt_data.$line_row ;
            }

            // Write to file
            $file_model->create_file( ASSETPATH."01get_text_file_from_cardgroup/export.txt");
            $file_model->write_to_file( ASSETPATH."01get_text_file_from_cardgroup/export.txt", 
                                        $line_column."\n".$txt_data );
            $what_happened =  "ท่านกำลังส่งออกชุดบัตรคำหมายเลข $cardgroup_id จำนวน $num_card ข้อ <br>";
            $what_happened .= "ตาวโหลดได้ที่ ".ASSETPATH."01get_text_file_from_cardgroup/export.txt";
            $data	=  [    "page_title"=>"บัตรคำได้ส่งออกเรียบร้อยแล้ว",
                            "what_happened"=>$what_happened,
                            "what_todo" => "กรุณาดาวน์โหลดเพื่อนำไปใช้งานต่อไป",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Admin", "manageCardgroup"])
                        ];
            $this->_warn($data);
        }

    }

}

