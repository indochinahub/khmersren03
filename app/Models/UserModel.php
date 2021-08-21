<?php

namespace App\Models;

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

            $user->displayname = $this->get_user_displayname($user);

            return $user;
            
        }else{
            return false;
        }
    }

    // return text
    public function get_user_displayname($obj_user){

        if( trim($obj_user->user_display_name) ){
            return $obj_user->user_display_name;

        }else{
            return $obj_user->user_username;    

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
    
    // return object or false
    public function get_by_post_id($post_id){

       $postcategory_model =new PostcategoryModel;
       if( !($postcategory = $postcategory_model->get_by_post_id($post_id)) ){ return false;}

        return $this->get_user_by_id( $postcategory->id_user );
    }

    public function run_one_time_a_day($user_id){
        $statistic_model = new StatisticModel;

        return $statistic_model->create_daily_statistic($user_id, time());
    }

    // return array_of_object
    public function get_last_visit_user_of_deck($deck_id, $num){

        $util_model = new UtilModel;

        $sql =  " SELECT id_user, MAX( practice_lastVisitDate) AS lastVisitDate ";
        $sql .= " FROM practice ";
        $sql .= " WHERE id_deck = $deck_id ";
        $sql .= " GROUP BY id_user ";
        $sql .= " ORDER BY lastVisitDate DESC ";
        $sql .= " LIMIT 0, $num ";
        $query = $this->query($sql);

        if( $arr_user = $query->getResult() ){
            $arr_id = $util_model->get_property_value_Of_many_objects_as_array(
                            $arr_user,
                            "id_user"
                        );
            return $this->get_by_ids($arr_id);

        }else{
            
            return [];
        }
    }




}



