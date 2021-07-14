<?php

namespace App\Models;

class DateTimeModel
{
    // return Int
    public function get_unix_timestamp($next_day = 0){
        return time() + (60*60*24*$next_day);
    }

    // return sql_timestamp
    public function unix_timestamp_to_sql_timestamp($unix_timestamp){
        return date('Y-m-d H:i:s', $unix_timestamp) ;
    }

    // return date_part text
    function get_date_part_from_sql_timestamp($sql_timestamp){
        if( strlen($sql_timestamp) == 19 ){
            return substr($sql_timestamp, 0, 10 );
        }else{
            die( "text of sql_time_stamp should be 19 charactors");
        }
    }
    
    // return unix_timestamp
    public function sql_timestamp_to_unix_timestamp($sql_timestamp){
        $dateTime = new \DateTime($sql_timestamp);
        return $dateTime->getTimestamp(); 
    }

    // return int
    public function get_unix_timestamp_at_midnight($unix_timestamp){

        $sql_timestamp = $this->unix_timestamp_to_sql_timestamp($unix_timestamp);
        $sql_timestamp_date_part = $this->get_date_part_from_sql_timestamp($sql_timestamp);
        $sql_timestamp_midnight = $sql_timestamp_date_part." 00:00:00" ;

        return $this->sql_timestamp_to_unix_timestamp($sql_timestamp_midnight);

    }





}


