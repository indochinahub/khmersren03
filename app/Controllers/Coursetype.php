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

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }


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

    public function addEdit($task,$post_id = "0"){

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit"  ){
            echo "to update";
            $data["task"] = "update";

        }elseif( $task === "edit"){
            echo "show form to edit";
            $data["task"] = "show_form_to_update";

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){
            echo "to insert";
            $data["task"] = "insert";

        }elseif( $task === "new" ){
            echo "show_form_to_insert";
            $data["task"] = "show_form_to_insert";
        }

    }

    public function delete($id, $confirm = "0"){

        $coursetype_model = new CoursetypeModel;
        $coursetype = $coursetype_model->get_by_id($id);

        if( $confirm === "0" ){

            $data    =  [   "page_title"=>"ยืนยันการลบบทความ",
                            "what_happened"=>"ท่านกำลังลบกลุ่มวิชา $id :: $coursetype->coursetype_name",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Coursetype","delete", $id, "1"]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => $this->_get_backlink(),
                        ];  		

            $this->_view("confirm",$data);

        }else{
            $coursetype_model->delete_by_id($id);
            return redirect()->to( base_url( ["Coursetype","manageCoursetype"] ));		

            



        }

        

    }

    

}

