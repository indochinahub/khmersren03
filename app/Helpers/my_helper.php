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

    // return text
    function get_userlevel_text($user_level){
        
        if($user_level == 1){
            return "ผู้เรียน";
        }elseif($user_level == 2){
            return "ครู";
        }elseif($user_level == 3){
            return "ผู้ดูแลระบบ";
        }
    }    
