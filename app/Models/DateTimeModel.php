<?php

namespace App\Models;

class DatetimeModel
{
    // return Int
    public function get_unix_timestamp($unix_timestamp , $next_day = 0){
        return $unix_timestamp + (60*60*24*$next_day);
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
    public function get_unix_timestamp_at_midnight($unix_timestamp, $next_day = 0){

        $unix_timestamp = $unix_timestamp + ( 60 * 60 * 24 * $next_day   );
        $sql_timestamp = $this->unix_timestamp_to_sql_timestamp($unix_timestamp);
        $sql_timestamp_date_part = $this->get_date_part_from_sql_timestamp($sql_timestamp);
        $sql_timestamp_midnight = $sql_timestamp_date_part." 00:00:00" ;

        return $this->sql_timestamp_to_unix_timestamp($sql_timestamp_midnight);

    }

    // return int
    function get_iterval_num_day( $current_interval, $interval_constant){
        if($current_interval < 2){
            return 2;
        }else{
            $new_interval = floor( $current_interval * $interval_constant );
            if($new_interval >= 10000){$new_interval = 10000;}
            return intval($new_interval);
        }
    }

    // return text
    function get_thai_date_from_sql_timestamp($sql_timestamp){
        // echo "All :: $sql_time_stamp <br>";
        // echo "Thai Year :: ".substr($sql_time_stamp,0,4)."<br>";
        // echo "Thai Month :: ".substr($sql_time_stamp,5,2)."<br>";
        // echo "Thai Date :: ".substr($sql_time_stamp,8,2)."<br>";
        // echo "Time :: ".substr($sql_time_stamp,11,5)."<br>";
        // echo "<hr>";

        // Get date
        $thai_date = substr($sql_timestamp,8,2);

        // Get month
        if( substr($sql_timestamp,5,2)     == "01"){ $thai_month = "ม.ค.";}
        elseif(substr($sql_timestamp,5,2)  == "02"){ $thai_month = "ก.พ.";}
        elseif(substr($sql_timestamp,5,2) == "03"){  $thai_month = "มี.ค.";}
        elseif(substr($sql_timestamp,5,2) == "04"){  $thai_month = "เม.ย.";}
        elseif(substr($sql_timestamp,5,2) == "05"){  $thai_month = "พ.ค.";}
        elseif(substr($sql_timestamp,5,2) == "06"){  $thai_month = "มิ.ย.";}
        elseif(substr($sql_timestamp,5,2) == "07"){  $thai_month = "ก.ค.";}
        elseif(substr($sql_timestamp,5,2) == "08"){  $thai_month = "ส.ค.";}
        elseif(substr($sql_timestamp,5,2) == "09"){  $thai_month = "ก.ย.";}
        elseif(substr($sql_timestamp,5,2) == "10"){  $thai_month = "ต.ค.";}
        elseif(substr($sql_timestamp,5,2) == "11"){  $thai_month = "พ.ย.";}
        elseif(substr($sql_timestamp,5,2) == "12"){  $thai_month = "ธ.ค.";}

        // Get thai year
        $thai_year = substr($sql_timestamp, 0, 4) + 543 ;  
        
        return "$thai_date $thai_month $thai_year";
    }

    // return text
    function get_thai_datetime_from_sql_timestamp($sql_timestamp){

        $thai_date_month_year = $this->get_thai_date_from_sql_timestamp($sql_timestamp);
        $time = substr($sql_timestamp,11,5);
        
        return "$thai_date_month_year $time น.";
    }   
    
    // return text
    function get_second_in_minute_and_hour( $second ){

        if( $second < 60){
            return $second." วินาที";

        }elseif( $second < 3600){
            $minute = round ($second/60 , $precision = 0 ) ;
            return $minute." นาที"; 

        }else{
            $hour = round ($second/3600 , $precision = 2 ) ;
            return $hour." ชั่วโมง";

        }
    }

    // return array of text
    public function get_last_num_day_midnight($unix_timestamp, $num_day){
        
        $arr_date = [];
        for ($num_day = 0; $num_day <= 14; $num_day++) {
            $midnight_unix_timestamp = $this->get_unix_timestamp_at_midnight(
                                            $unix_timestamp, 
                                            $next_day = -$num_day
                                        );
            array_push  (   $arr_date,
                            $this->unix_timestamp_to_sql_timestamp( $midnight_unix_timestamp)
                        );
        }
        return $arr_date;
    }



}


