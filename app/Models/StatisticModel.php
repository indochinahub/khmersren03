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

}


