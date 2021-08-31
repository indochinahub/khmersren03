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


class Apply extends MyController
{
    public function register(){

        if( $data["user"] = $this->_get_loggedin_user() ){
            return redirect()->to(base_url(["User","logout"]));		
        }

        $data["page_title"] = 	"สมัครสมาชิกใหม่";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];	        
        $this->_view("register",$data);               
    }


}

