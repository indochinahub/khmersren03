<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\CardgroupModel;
use App\Models\DeckpModel;
use App\Models\DateTimeModel;

class StatisticModel extends MyModel
{

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

    // return array of text
    public function get_last_midnight($unix_timestamp, $num_day){
        $datetime_model = new DateTimeModel;

        $arr_date = [];
        for ($num_day = 0; $num_day <= 14; $num_day++) {
            $midnight_unix_timestamp = $datetime_model->get_unix_timestamp_at_midnight(
                                            $unix_timestamp, 
                                            $next_day = -$num_day
                                        );
            array_push  (   $arr_date,
                            $datetime_model->unix_timestamp_to_sql_timestamp( $midnight_unix_timestamp)
                        );
        }
        return $arr_date;
    }

}


