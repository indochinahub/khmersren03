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
use \App\Models\PostModel;
use \App\Models\MediaModel;
use \App\Models\PostcategoryModel;
use \App\Models\PaginationModel;
use \App\Models\MessageModel;

class Message extends MyController
{
    public function myMessage(){

        $message_model = new MessageModel;
        $user_model = new UserModel;
        $datetime_model = new DatetimeModel;
        $util_model = new UtilModel;

        // Check user's previlege
        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }
        
        $arr_other_id = $message_model->get_other_id_wchich_chatted_with_user($user->user_id);


        $data["arr_message"] = [];
        foreach( $arr_other_id as $other_id  ){

            $message = $message_model->get_last_active_messge_with_other($user->user_id,$other_id);

            $other = $user_model->get_by_id($other_id);
            $message->other = $other;
            $message->other_displayname = $user_model->get_user_displayname($other);

            $message->thai_active_date = $datetime_model->get_thai_datetime_from_sql_timestamp($message->active_date);
            $message->num_unread = $message_model->get_num_unread_message($user->user_id,$other_id);

            array_push($data["arr_message"],$message);
        }

        $data["arr_message"] = $util_model->sort_array_of_object_by_the_property( 
                                    $data["arr_message"], 
                                    "active_date", 
                                    $order_by ="desc"
                                );



        $data["page_title"] = 	"ข้อความของฉัน ";
        $data["page_link"] 	= 	[	"กลับ",
                                    $this->_get_backlink()
                                ];	        
        $this->_view("myMessage",$data);
    }

    public function with($other_id){

        $user_model = new UserModel;
        $message_model = new MessageModel;
        $datetime_model = new DatetimeModel;
        $pagination_model = new PaginationModel;
        $util_model = new UtilModel;

        // Check user's previlege
        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["user_displayname"] = $user_model->get_user_displayname($data["user"]);
        $data["other"] = $user_model->get_by_id($other_id);
        $data["other_displayname"] = $user_model->get_user_displayname($data["other"]);

        $arr_message = $message_model->get_message_with_other($data["user"]->user_id,$other_id);

        if( ! ($page = $this->request->getGet('page')) ){
            $page = 1;
        }                                

        $pagination = $pagination_model->get_pagination( 
                            $arr_message, 
                            $current_page = $page , 
                            $per_page = 15
                        );
        $data["pagination_link"] = $pagination->link;
        $arr_message = $pagination->arr_row; 

        $arr_message = $util_model->sort_array_of_object_by_the_property( 
            $arr_message, 
            "message_id", 
            $order_by ="asc"
        );

        $data["arr_message"] = [];
        foreach( $arr_message as $message){

            if( $message->id_sender === $data["user"]->user_id){
                $message->role = "i_am_sender";
            }else{
                $message->role = "i_am_reciever";
            }

            $message->message_sendtime = $datetime_model->get_thai_datetime_from_sql_timestamp($message->message_sendtime);

            if( $message->message_readtime ){
                $message->message_readtime = "อ่านเมื่อ ".$datetime_model->get_thai_datetime_from_sql_timestamp($message->message_readtime);
            }else{
                $message->message_readtime = "[ผู้รับยังไม่ได้อ่าน]";
            }

            if( $message->message_picture01 ){
                $message->message_text =  "<div style='border:1px solid black;margin-bottom:10px'>";
                $message->message_text .= "<img src='". base_url(["asset","media","message_media",$message->message_picture01]) ."' class='img-fluid'>";
                $message->message_text .= "</div>";

            }elseif( $message->message_youtube01 ){
                $message->message_text =  "<div style='margin-bottom:10px;width:250px'>";
                $message->message_text .= "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$message->message_youtube01."' allowfullscreen=''></iframe>";
                $message->message_text .= "</div>";

            }elseif( $message->message_text ){
                $message->message_text = nl2br($message->message_text);

            }

            array_push($data["arr_message"], $message);
        }

        // Set Read time
        $message_model->set_read_time( $data["user"]->user_id,$other_id,time());

        $data["page_title"] = 	"ข้อความกับ ".$data["other_displayname"];
        $data["page_link"] 	= 	[	"ข้อความของฉัน",
                                    base_url(["Message","myMessage"])
                                ];	        
        $this->_view("with",$data);
    }

    
    public function send($other_id){
        
        $message_model = new MessageModel;

        // Check user's previlege
        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $validattion_rules = 	[ 
                                    "message_text" => "required",
                                ];            

        if(  $this->request->getMethod() === "post" && 
             $this->validate($validattion_rules)
        ){

            $detail = [ 
                        "id_sender"=>$data["user"]->user_id,
                        "id_receiver"=>$other_id,
                        "message_text"=>$this->request->getPost("message_text") 
                      ];
            $message_model->insert($detail);
            return redirect()->to( $this->_get_backlink() );		

        }else{

            $data	= [     "page_title"=>"ไม่สามารถส่งข้อความได้",
                            "what_happened"=>"ไม่สามารถส่งข้อความได้ มีข้อผิดพลาดต่อไปนี้ : ".$this->validator->getError("message_text"),
                            "what_todo" => "คลิ๊กที่ปุ่ม <bold>กลับ</bold> เพื่อกลับห้องสนทนา",
                            "btnText_toGo" => "กลับ",
                            "btnLink_toGo" => $this->_get_backlink()
                        ];
            $this->_warn($data);            

        }
    }

    public function addBlank($other_id){

        $user_model = new UserModel;
        $message_model = new MessageModel;

        // Check user's previlege
        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $detail =   [ 
                        "id_sender"=>$user->user_id,
                        "id_receiver"=>$other_id,
                        "message_text"=>null 
                    ];
        $message_model->insert($detail);
        return redirect()->to( $this->_get_backlink() );        

    }

    public function delete($message_id){
        $message_model = new MessageModel;
        $message_model->delete_by_id($message_id);

        return redirect()->to($this->_get_backlink());
    }
    
}

