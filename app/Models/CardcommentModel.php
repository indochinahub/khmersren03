<?php

namespace App\Models;
use App\Models\DatetimeModel;

class CardcommentModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "cardcomment";
        $this->primaryKey = $this->table."_id";
    }

    // return array of object
    public function get_by_deck_id($deck_id){

        $where_clause = " WHERE  id_deck = ".$deck_id;
        return $this->get_where($where_clause);

    }

    // return array of object
    public function get_by_card_id_and_deck_id($card_id, $deck_id){

        $where_clause = " WHERE id_card = ".$card_id." AND id_deck = ".$deck_id;
        return $this->get_where($where_clause);

    }


}





