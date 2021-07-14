<?php

    // return text
    function get_text_of_minute_and_hour_by_second($second){

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
