<?php

namespace App\Models;

use App\Models\DeckModel;
use App\Models\CourseModel;
use App\Models\CardgroupModel;
use App\Models\UtilModel;

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
    public function get_other_id_wchich_chatted_with_user($user_id){
        
        $util_model = new UtilModel;

        $where_clause =     " WHERE id_sender = $user_id OR  id_receiver = $user_id ";
        $where_clause .=    " ORDER BY message_id DESC ";

        $sql =  " SELECT id_sender, id_receiver ";
        $sql .= " FROM message ";
        $sql .= " WHERE id_sender = $user_id OR  id_receiver = $user_id ";

        $query = $this->query($sql);
        if( $arr_result = $query->getResult() ){

            $arr_sender_id = $util_model->get_property_value_Of_many_objects_as_array( $arr_result , "id_sender");
            $arr_receiver_id = $util_model->get_property_value_Of_many_objects_as_array( $arr_result , "id_receiver");
            
            $arr_related_user_id = array_unique( array_values( array_merge($arr_sender_id, $arr_receiver_id) ) ) ;
            $arr_related_user_id = array_diff( $arr_related_user_id, [$user_id]);

            return array_values( $arr_related_user_id );

        }else{
            return [];

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


