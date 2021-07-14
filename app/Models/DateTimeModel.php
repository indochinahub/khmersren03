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





}


