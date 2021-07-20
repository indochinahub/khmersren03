<?php

namespace App\Models;
use App\Models\DateTimeModel;

class UserModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "user";
        $this->primaryKey = $this->table."_id";
    }

    // return UserObject or False
    public function get_validated_user($username, $password){
        $username = $this->db->escape(trim($username));
        $password = $this->db->escape(trim($password));

        $where_clause = " WHERE user_username = ".$username." AND user_password = ".$password;
        if( $arr_row = $this->get_where( $where_clause ) ){
            return $arr_row[0];

        }else{
            return false;

        }

    }

    //return Object or false
    public function get_user_by_id($user_id){

        if( $user = $this->get_by_id( $user_id )){

            if( $user->user_display_name ){
                $user->displayname = $user->user_display_name;
            }else{
                $user->displayname = $user->user_username;    
            }
            return $user;
        }else{
            return false;
        }
    }

    //return URL 
    public function get_avarta_url($user_id){
        $util_model = new UtilModel();

        $path       =   ASSETPATH."avatar/";

        $filename   =  $util_model->add_leading_zero_to_number( 
                                        $text = $user_id, 
                                        $num_required_digit = 5
                                        );
        $filename  .= "1.jpg";

        if( file_exists( $path.$filename )){
            return base_url(["asset", "avatar", $filename]);

        }else{
            return base_url(["asset", "avatar", "anonymous.jpg"]);
        }

    }

    // return affected rows
    public function update_visit_time($user_id){

        $datetime_model = new DateTimeModel;

        $detail = [ 
                "user_visit_time" => $datetime_model->unix_timestamp_to_sql_timestamp(time()) 
                ];

        return $this->update_by_id($user_id, $detail);
    }    


}


