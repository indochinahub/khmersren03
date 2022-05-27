<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\CardgroupModel;
use App\Models\DeckpModel;
use App\Models\DatetimeModel;

class StatisticModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "statistic";
        $this->primaryKey = $this->table."_id";
    }

    // return int
    public function get_sum_spenttime_by_user_id_and_deck_id($user_id,$deck_id){

        $sql =  " SELECT sum(statistic_timespent) AS timespent ";
        $sql .= " FROM statistic ";
        $sql .= " WHERE id_user = $user_id AND id_deck = $deck_id ";
        $query = $this->db->query($sql);

        if( $result = $query->getResult() ){
            return (int) $result[0]->timespent;

       }else{
           return 0;
       }

    }

    // return num_rows
    public function reset_practice_timespent($user_id){
        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  id_user = $user_id ";
        $query = $this->query($sql);

        return $this->db->affectedRows();
    }

    //return array of statistic
    public function get_now_statistic($user_id){

        $sql  =   " SELECT id_deck, count(practice_id) as num_card, sum(practice_timespent) as timespent ";
        $sql  .=  " FROM practice ";
        $sql  .=  " WHERE id_user = $user_id  AND practice_timespent > 0 ";
        $sql  .=  " GROUP BY id_deck ";
        $query = $this->query($sql);

        return $arr_result = $query->getResult();
    }

    // return array of key id
    public function create_daily_statistic($user_id, $unix_timestamp){
        $datetime_model = new DatetimeModel;

        // if there is today statistic , No need to create statistic
        if( $this->if_there_is_today_statistic($user_id, $unix_timestamp)){ return []; }

        $arr_statistic = $this->get_now_statistic($user_id);

        $today_midnight =   $datetime_model->unix_timestamp_to_sql_timestamp(
                                    $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 0)  
                            );

        $arr_id = [];
        foreach( $arr_statistic as $statistic){
            $detail =   [   "id_user"               =>  $user_id, 
                            "id_deck"               =>  $statistic->id_deck,
                            "statistic_numcard"     =>  $statistic->num_card,
                            "statistic_timespent"   =>  $statistic->timespent,
                            "statistic_datetime"    =>  $today_midnight
                        ];
            
            array_push ( $arr_id, $this->insert($detail) );
        }

        // Clear statistic
        $this->reset_practice_timespent($user_id);

        return $arr_id;
    }

    // return true or false
    public function if_there_is_today_statistic($user_id, $unix_timestamp){
        $datetime_model = new DatetimeModel;

        $today_midnight =   $datetime_model->unix_timestamp_to_sql_timestamp(
                                  $datetime_model->get_unix_timestamp_at_midnight( $unix_timestamp, $next_day = 0)  
                            );

        $where_clause = " WHERE id_user = $user_id AND statistic_datetime = '$today_midnight' ";                    
        if( $this->get_where($where_clause) ){
            return true;

        }else{
            return false;
        }
    }

    // return array of statistic
    public function get_daily_statistic($user_id){

        $sql  =  " SELECT statistic_datetime, ";
        $sql  .=  " sum(statistic_timespent) as timespent, ";
        $sql  .=  " sum(statistic_numcard) as num_card  ";
        $sql  .=  " FROM statistic  ";
        $sql  .=  " WHERE id_user = $user_id ";
        $sql  .=  " GROUP BY statistic_datetime ";
        $sql  .=  " ORDER BY statistic_datetime DESC ";

        $query = $this->query($sql);

        if( $arr_result = $query->getResult() ){
            return $arr_result;

        }else{
            return [];

        }

    }

    //return arr of statistic
    public function get_last_15_day_statistic( $user_id, $unix_timestamp ){

        $util_model = new UtilModel;
        $datetime_model = new DatetimeModel;

        $arr_daily_statistic = $this->get_daily_statistic( $user_id );
        $assoc_daily_statistic = $util_model->get_assoc_from_array_of_object(
                                    $arr_daily_statistic , 
                                    $key_property = "statistic_datetime"
                                );        

        $arr_date = $datetime_model->get_last_num_day_midnight(
                                    $unix_timestamp, 15);

        $data["arr_statistic"] = [];
        foreach( $arr_date as $date ){                                    
            $statistic = new \stdClass;

            $statistic->date = $date ;

            if( array_key_exists( $date, $assoc_daily_statistic ) ){
                $daily_statistic = $assoc_daily_statistic[ $date ];

                $statistic->timespent = $daily_statistic->timespent;
                $statistic->num_card  = $daily_statistic->num_card;

            }else{
                $statistic->timespent = 0;
                $statistic->num_card  = 0;
            }

            array_push($data["arr_statistic"], $statistic);
        }

        return $data["arr_statistic"];
    }

    //return int or false
    public function get_num_day_from_start($user_id){

        $datetime_model = new DatetimeModel;

        $where_clause =  " WHERE id_user = $user_id ";
        $where_clause .= " ORDER BY statistic_datetime asc ";
        if( $arr_statistic = $this->get_where($where_clause) ){

            $start_unix_timestamp  = $datetime_model->sql_timestamp_to_unix_timestamp( $arr_statistic[0]->statistic_datetime );

            return floor( (time() - $start_unix_timestamp  )/ (60*60*24) );

        }else{
            return 0;
        }
    }

    // return int or zero
    public function get_total_timespent_of_user($user_id){

        $sql =  " SELECT sum(statistic_timespent) as timespent FROM statistic ";
        $sql .= " WHERE id_user = $user_id ";
        $query = $this->query($sql);

        $result = $query->getResult();

        if( $timespent = $result[0]->timespent ){
            return $timespent;

        }else{
            return 0;
        }
    }

}


