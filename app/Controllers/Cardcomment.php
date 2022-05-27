<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DatetimeModel;
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
        $datetime_model     = new DatetimeModel;
        
        $assoc_deck     =  $deck_model->get_all_rows_as_assoc();
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
            $cardcomment->card                  = $card_model->get_by_id($cardcomment->id_card);
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

    public function add($card_id,$deck_id){

        $cardcomment_model = new CardcommentModel;

        $validattion_rules = 	[ 
                                    "cardcomment_text" => "required",
                                ];            

        $user = $this->_get_loggedin_user();

        if(     $this->request->getMethod() === "post"  && 
                $this->validate($validattion_rules)
          ){

            $detail =   [
                            "id_user"=>$user->user_id,
                            "id_card"=>$card_id, 
                            "id_deck"=>$deck_id,
                            "cardcomment_text"=>$this->request->getPost("cardcomment_text")
                        ];
            $cardcomment_model->insert($detail);
            return redirect()->to( $this->_get_backlink() );		
            
        }else{

            $data	= [     "page_title"=>"มีข้อผิดพลาด",
                            "what_happened"=>"ข้อผิดพลาดดังต่อไปนี้ :: ".$this->validator->getError("cardcomment_text"),
                            "what_todo" => "คลิ๊กที่ปุ่ม <bold>กลับ</bold> เพื่อกลับไปบัตรคำ",
                            "btnText_toGo" => "กลับ",
                            "btnLink_toGo" => $this->_get_backlink()
                    ];
            $this->_warn($data);
        }
    }

    public function delete($cardcomment_id, $confirm = "0"){

        $cardcomment_model = new CardcommentModel;

        if( $confirm === "0" ){
            $data    =  [   "page_title"=>"ยืนยันการลบความเห็น",
                            "what_happened"=>"ท่านกำลังความคิดเห็นหมายเลข $cardcomment_id ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url( ["Cardcomment","delete",$cardcomment_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => $this->_get_backlink(),
                        ];  		

            $this->_view("confirm",$data);

        }else{
            $cardcomment = $cardcomment_model->get_by_id( $cardcomment_id );
            $cardcomment_model->delete_by_id($cardcomment_id);
            return redirect()->to(base_url(["Card","show","a",$cardcomment->id_card,$cardcomment->id_deck]));		

        }
    }

}

