<?php

namespace App\Models;
use App\Models\DateTimeModel;

class CardcommentModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "cardcomment";
        $this->primaryKey = $this->table."_id";
    }

    // return One
    public function returnOne(){

        return 1;

    }


}


