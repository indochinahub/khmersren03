<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\StatisticModel;
use App\Models\DateTimeModel;


class Admin extends MyController
{

    public function dashboard(){

        $data["page_title"] = 	"แดชบอร์ดผู้ดูแล";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];		
        $this->_view("dashboard",$data);        
    }

    public function exportCardgroup(){

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{

            $this->_needToBeAdmin();
            return;
        }        




        $data["page_title"] = 	"ชุตบัตรคำ "; 
        $data["page_link"] 	= 	[	"หน้าแรก ",
                                    base_url()
                               ];	        
        $this->_view("show",$data);                


    }

    

}

