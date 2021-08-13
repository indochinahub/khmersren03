<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\CardgroupModel;
use App\Models\DeckpModel;
use App\Models\DateTimeModel;

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
    public function create_daily_statistic($user_id){
        $datetime_model = new DateTimeModel;

        $arr_statistic = $this->get_now_statistic($user_id);

        $today_midnight =   $datetime_model->unix_timestamp_to_sql_timestamp(
                                    $datetime_model->get_unix_timestamp_at_midnight( time(), $next_day = 0)  
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
        $datetime_model = new DateTimeModel;

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

}


