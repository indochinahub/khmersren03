<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DateTimeModel;
use \App\Models\UtilModel;

class Cardcomment extends MyController
{
    public function showAll(){

        $data["page_title"] = 	"ความเห็นต่อบัตรคำทั้งหมด";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];	        
        $this->_view("showAll",$data);

    }
}

