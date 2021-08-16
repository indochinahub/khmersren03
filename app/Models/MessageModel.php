<?php

namespace App\Models;

use App\Models\DeckModel;
use App\Models\CourseModel;
use App\Models\CardgroupModel;

class MessageModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "message";
        $this->primaryKey = $this->table."_id";
    }

    //return array of object with new property
    public function add_active_date_property_to_message($arr_message){

        $new_arr_message = [];
        foreach( $arr_message as $message){

            if( $message->message_readdate ){
                $message->active_date = $message->message_readdate;
            }else{
                $message->active_date = $message->message_senddate;
            }
            
            array_push($new_arr_message,$message);
        }

        return $new_arr_message;
    }



    // return array of object
    public function get_message_related_to_user($user_id){

        $where_clause =     " WHERE id_sender = $user_id OR  id_receiver = $user_id ";
        $where_clause .=    " ORDER BY message_id DESC ";

        if( $arr_message = $this->get_where($where_clause) ){


        }        
        

    }


    /*
    public function get_user_id_who_chat_with($user_id){

        
        $where_clause =     " WHERE (id_sender = $user_id  AND id_receiver = $member_id) ";
        $where_clause .=    " OR (id_sender = $member_id  AND id_receiver = $user_id) ";
        $where_clause .=    " ORDER BY message_id DESC ";

    }        
    */ 



}


