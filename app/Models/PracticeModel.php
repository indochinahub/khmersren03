<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\DatetimeModel;

class PracticeModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "practice";
        $this->primaryKey = $this->table."_id";
    }

    //return array of ojbect or blank array
    public function get_by_deck_id_user_id($deck_id, $user_id){
        $util_model = new UtilModel();

        $where_clause = " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;
        return $this->get_where($where_clause);
    }

    // return array of object
    public function get_to_review($deck_id, $user_id, $unix_timestamp, $next_day){

        $datetime_model = new DatetimeModel();
        $util_model = new UtilModel();

        $unix_timestamp = $datetime_model->get_unix_timestamp($unix_timestamp, $next_day);
        $sql_time_stamp = $datetime_model->unix_timestamp_to_sql_timestamp($unix_timestamp);

        $where_clause       =   " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;
        $where_clause       .=  " AND practice_nextvisittime < '$sql_time_stamp' " ;
        $where_clause       .=  " ORDER BY practice_intervalDay DESC ";

        return  $this->get_where($where_clause);
    }

    // return int
    public function get_total_num_to_review($user_id, $unix_timestamp, $next_day){

        $datetime_model = new DatetimeModel();

        $today_midnight = $datetime_model->unix_timestamp_to_sql_timestamp(
                                    $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day)                            
                                );
        $sql =  " SELECT count(practice_id) as num FROM practice ";
        $sql .= " WHERE id_user = $user_id AND practice_nextvisittime < '$today_midnight' ";

        $query = $this->query($sql);
        $num = $query->getResult()[0]->num;
        return (int) $num;

    }

    // return object or false
    public function get_by_card_id_deck_id_user_id($card_id, $deck_id, $user_id){

        $where_clause = " WHERE id_deck = $deck_id AND id_user = $user_id AND id_card = $card_id "; 

        if( $arr_practice = $this->get_where($where_clause) ){
            return $arr_practice[0];

        }else{
            return false;
        }
    }

    // return object or false
    public function get_last_by_user_id($user_id){

        $where_clause  = " WHERE id_user = $user_id ";
        $where_clause .= " ORDER BY practice_lastvisittime desc ";
        $where_clause .= " LIMIT 0,1 ";

        if( $arr_practice = $query = $this->get_where($where_clause)){
            return $arr_practice[0]; 

        }else{
            return false;

        }
    }

    // return int
    public function get_sum_visit_time($deck_id, $user_id){

        $sql    =       " SELECT SUM(practice_counter)  as 'number'  ";
        $sql    .=      " FROM practice ";
        $sql    .=      " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;                
        $query = $this->query($sql);

        if(  $time = $query->getResult()[0]->number){
            return (int) $time;

        }else{
            return 0;
        }

    }

    // return Int Or Zero
    public function get_average_interval($deck_id,$user_id){

        $util_model = new UtilModel();

        $sql = "SELECT practice_intervalDay from practice WHERE id_deck = ".$deck_id." AND id_user = ".$user_id ;
        $sql .= " ORDER By practice_intervalDay ASC LIMIT 0,5 ";
        
        $query = $this->query($sql);
        $arr_row = $query->getResult();

        if( count($arr_row) == 5  ){
            $average = $util_model->get_average_property_of_arr_object( $arr_row, "practice_intervalDay");
            return intval($average);

        }else{
            return 0;
        }
    }    

    // return int or zero
    public function get_num_practice_have_done_of_the_day($user_id, $unix_timestamp){

        $datetime_model = new DatetimeModel;
        
        $lower_boundry_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
                                            $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 0)                            
                                        );
        $upper_boundry_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
                                            $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 1)
                                        );
        
        $sql =  " SELECT count(practice_id) AS num_card FROM practice WHERE id_user = $user_id ";
        $sql .= " AND practice_lastvisittime > '$lower_boundry_sql_timestamp' AND practice_lastvisittime < '$upper_boundry_sql_timestamp' ";

        $query = $this->query($sql);

        $num = $query->getResult()[0]->num_card;
        return (int)$num;
    }

    // return int
    public function get_timespent_of_the_day($user_id, $unix_timestamp){

        $datetime_model = new DatetimeModel;

        $lower_boundry_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
                                            $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 0)                            
                                        );
        $upper_boundry_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
                                            $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 1)
                                        );        

        $sql =  " SELECT sum(practice_timespent) AS timespent  FROM practice WHERE id_user = $user_id ";
        $sql .= " AND practice_lastvisittime > '$lower_boundry_sql_timestamp' AND practice_lastvisittime < '$upper_boundry_sql_timestamp' ";

        $query = $this->query($sql);

        $timespent = $query->getResult()[0]->timespent;
        return (int)$timespent;        
    }





}


