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

            $arr_text = explode( "@", $obj_user->user_username);
            return $arr_text[0];    
        }

    }

    //return URL 
    public function get_avarta_url($user_obj){
        
        if( $user_obj->user_picture01 ) {
            return base_url(["asset","media","user_media",$user_obj->user_picture01]);
        }else{
            return base_url(["asset","media","user_media","anonymous.jpg" ]);
        }
    }

    // return affected rows
    public function update_visit_time($user_id){

        $datetime_model = new DatetimeModel;

        $detail = [ 
                "user_visittime" => $datetime_model->unix_timestamp_to_sql_timestamp(time()) 
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

        return $this->get_last_visit_user_of_decks([$deck_id], $num);
    }

    // return array_of_object
    public function get_last_visit_user_of_decks($arr_deck_id, $num){

        $util_model = new UtilModel;

        if( ! $arr_deck_id ){ return []; }

        $arr_deck_id_text =  "(".$util_model->get_line_of_text_from_array ($arr_deck_id, ",").")";

        $sql =  " SELECT id_user, MAX( practice_lastvisittime) AS lastVisittime ";
        $sql .= " FROM practice ";
        $sql .= " WHERE id_deck in $arr_deck_id_text ";
        $sql .= " GROUP BY id_user ";
        $sql .= " ORDER BY lastVisittime DESC ";
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

    // return array of user
    public function get_last_visit_user_of_course($course_id, $num){

        $deck_model = new DeckModel;
        $util_model = new UtilModel;

        $arr_deck = $deck_model->get_by_course_id($course_id);
        $arr_deck_id = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_deck,
                                    "deck_id"
                                );
        return $this->get_last_visit_user_of_decks($arr_deck_id, $num);
    }

    // return array of user;
    public function get_last_visit_of_card_and_deck($card_id, $deck_id , $num){

        $util_model = new UtilModel;
        $sql =  " SELECT id_user, MAX( practice_lastvisittime ) AS visittime ";
        $sql .= " FROM practice ";
        $sql .= " WHERE id_deck = $deck_id AND id_card = $card_id ";
        $sql .= " GROUP BY id_user ";
        $sql .= " ORDER BY visittime DESC ";
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

    // return user object or false
    public function get_user_by_username( $username ){

        $username = strtolower($username); 

        $where_clause = " WHERE user_username = '".$username."' ";
        if( $arr_user = $this->get_where( $where_clause ) ){
            return $arr_user[0];

        }else{
            return false;
        }

    }


}



