<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DatetimeModel;
use \App\Models\UtilModel;
use \App\Models\PostModel;
use \App\Models\MediaModel;
use \App\Models\PostcategoryModel;
use \App\Models\PaginationModel;
use \App\Models\FollowModel;
use \App\Models\MessageModel;
use \App\Models\CoursetypeModel;


class Coursetype extends MyController
{
    public function manageCoursetype(){

        $coursetype_model = new CoursetypeModel;

        $arr_coursetype = $coursetype_model->get_all_row();

        $data["arr_coursetype"] = [];
        foreach( $arr_coursetype as $coursetype){

            $coursetype->num_coure = 55;
            array_push($data["arr_coursetype"], $coursetype);
        }


        $data["page_title"] = 	"จัดการประเภทวิชา ";
        $data["page_link"] 	= 	[	"กลับ",
                                    $this->_get_backlink()
                                ];	        
        $this->_view("manageCoursetype",$data);                       
    }

}

