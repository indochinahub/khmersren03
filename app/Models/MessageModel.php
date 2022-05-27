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

            if( $message->message_readtime ){
                $message->active_date = $message->message_readtime;
            }else{
                $message->active_date = $message->message_sendtime;
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

    // return object or false
    public function get_last_active_messge_with_other($user_id,$other_id){
        
        $util_model = new UtilModel;

        $where_clause =  " WHERE (id_sender = $user_id  AND id_receiver = $other_id) ";
        $where_clause .= " OR (id_sender = $other_id  AND id_receiver = $user_id) ";

        if( $arr_message = $this->get_where($where_clause) ){

            $arr_message = $this->add_active_date_property_to_message($arr_message);
            $arr_message = $util_model->sort_array_of_object_by_the_property( 
                                            $arr_message, 
                                            "active_date", 
                                            $order_by ="desc"
                                        );
            return $arr_message[0];
        }else{

            return false;
        }
    }

    // return array
    public function get_message_with_other($user_id,$other_id){

        $where_clause =     " WHERE (id_sender = $user_id  AND id_receiver = $other_id) ";
        $where_clause .=    " OR (id_sender = $other_id AND id_receiver = $user_id) ";
        $where_clause .=    " ORDER BY message_id DESC ";

        if( $arr_message = $this->get_where($where_clause) ){
            $arr_message = $this->add_active_date_property_to_message($arr_message);
            return $arr_message;

        }else{
            return [];

        }
    }

    // return  int
    public function get_num_unread_message($user_id,$other_id){

        $sql =  " SELECT COUNT(message_id) as num ";
        $sql .= " FROM message ";
        $sql .= " WHERE id_sender = $other_id AND id_receiver = $user_id AND message_readtime IS NULL ";
        
        $query = $this->query($sql);
        $result = $query->getResult();

        return (int)  $result[0]->num; 
    }

    // return int
    public function get_total_num_unread_message($user_id){

        $sql =  " SELECT COUNT(message_id) as num ";
        $sql .= " FROM message ";
        $sql .= " WHERE id_receiver = $user_id AND message_readtime IS NULL ";
        
        $query = $this->query($sql);
        $result = $query->getResult();

        return (int)  $result[0]->num;         
    }

    // return num rows
    public function set_read_time($user_id,$other_id,$unix_timestamp){

        $datetime_model = new DatetimeModel;

        $sql_timestamp =  $datetime_model->unix_timestamp_to_sql_timestamp($unix_timestamp);

        $sql =  " UPDATE message SET message_readtime='$sql_timestamp' ";
        $sql .= " WHERE  id_receiver = $user_id AND id_sender = $other_id ";
        $sql .= " AND message_readtime IS NULL ";

        $this->query($sql);

        return $this->db->affectedRows();
    }

}


