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

        $course_model = new CourseModel;
        $coursetype_model = new CoursetypeModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $arr_coursetype = $coursetype_model->get_all_row();

        $data["arr_coursetype"] = [];
        foreach( $arr_coursetype as $coursetype){

            $coursetype->num_coure = count($course_model->get_by_coursetype_id($coursetype->coursetype_id));
            array_push($data["arr_coursetype"], $coursetype);
        }

        $data["page_title"] = 	"จัดการประเภทวิชา ";
        $data["page_link"] 	= 	[	"กลับ",
                                    $this->_get_backlink()
                                ];	        
        $this->_view("manageCoursetype",$data);                       
    }

    public function addEdit($task,$id = "0"){

        $coursetype_model = new CoursetypeModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $validattion_rules = 	[ 'coursetype_name' => 'required|min_length[4]|max_length[40]' ];    

        // Set task
        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit" &&
             $this->validate($validattion_rules) 
          ){
            $data["task"] = "update";

        }elseif(($this->request->getMethod() === "post") && $task === "edit"){
            $data["task"] = "show_form_error";
        
        }elseif( $task === "edit"){
            $data["task"] = "show_form_to_edit";

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){

            $data["task"] = "insert";

        }elseif( $task === "new" ){
            $data["task"] = "show_form_to_insert";
        }

        // Do the task
        if( $data["task"] === "show_form_to_edit" ){
            $coursetype = $coursetype_model->get_by_id($id);

            $data["coursetype_id"] = $id;
            $data["coursetype_name"] = $coursetype->coursetype_name;
            
            $data["page_title"] = 	"แก้ไขกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);      
            
        }elseif( $data["task"] === "show_form_error"){
            $data["coursetype_id"] = $id;
            $data["coursetype_name"] = $this->request->getPost("coursetype_name");

            $data["coursetype_name_error"] = $this->validator->getError('coursetype_name');

            $data["page_title"] = 	"แก้ไขกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);      

        }elseif( $data["task"] === "update" ){
            $detail =   [   "coursetype_name"=>trim($this->request->getPost("coursetype_name"))
                        ];
            $coursetype_model->update_by_id($id, $detail );
            return redirect()->to(base_url([ "Coursetype","manageCoursetype" ]));	

        }elseif( $data["task"] === "show_form_to_insert" ){
            $data["coursetype_name"] = "";

            $data["page_title"] = 	"เพิ่มกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);      

        }elseif( $data["task"] === "insert" ){
            $detail =   [
                            "coursetype_name"=>trim($this->request->getPost("coursetype_name"))
                        ];
            $coursetype_model->insert($detail);
            return redirect()->to(base_url([ "Coursetype","manageCoursetype" ]));	            
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

