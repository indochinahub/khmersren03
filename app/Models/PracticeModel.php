<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\DateTimeModel;

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

        $datetime_model = new DateTimeModel();
        $util_model = new UtilModel();

        $unix_timestamp = $datetime_model->get_unix_timestamp($unix_timestamp, $next_day);
        $sql_time_stamp = $datetime_model->unix_timestamp_to_sql_timestamp($unix_timestamp);

        
        $where_clause = " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;


        $where_clause       =   " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;
        $where_clause       .=  " AND practice_nextVisitDate < '$sql_time_stamp' " ;
        $where_clause       .=  " ORDER BY practice_intervalDay DESC ";

        return  $this->get_where($where_clause);
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


}


