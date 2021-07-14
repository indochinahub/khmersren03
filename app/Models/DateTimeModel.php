<?php

namespace App\Models;

class DateTimeModel
{
    // return Int
    public function get_unix_timestamp($next_day = 0){
        return time() + (60*60*24*$next_day);
    }

    



}


