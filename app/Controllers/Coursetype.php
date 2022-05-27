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
        $util_model = new UtilModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $arr_coursetype = $coursetype_model->get_all_row();
        $arr_coursetype = $util_model->sort_array_of_object_by_the_property( 
                                        $arr_coursetype , 
                                        "coursetype_id", 
                                        $order_by ="desc"
                                    );

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

        // 01/06 Validation Rules and Default Value 
        $validattion_rules = 	[ 'coursetype_name' => 'required|min_length[4]|max_length[40]' ];

        $data["coursetype_id"] = "";
        $data["coursetype_name"] = "";

        // 02/06 Update data
        if( ($this->request->getMethod() === "post") && $task === "edit" &&
             $this->validate($validattion_rules) 
          ){

            $detail =   [   "coursetype_name"=>trim($this->request->getPost("coursetype_name"))
                        ];
            $coursetype_model->update_by_id($id, $detail );
            return redirect()->to(base_url([ "Coursetype","manageCoursetype" ]));	

        // 03/06 Insert data
        }elseif( ($this->request->getMethod() === "post") && ($task === "new") &&
            $this->validate($validattion_rules) 
          ){

            $detail =   [
                            "coursetype_name"=>trim($this->request->getPost("coursetype_name"))
                        ];
            $coursetype_model->insert($detail);
            return redirect()->to(base_url([ "Coursetype","manageCoursetype" ]));	            
            
        // 04/06 Show form with error
        }elseif(($this->request->getMethod() === "post") ){

            $data["coursetype_name"] = $this->request->getPost("coursetype_name");
            $data["coursetype_name_error"] = $this->validator->getError('coursetype_name');

            $data["page_title"] = 	"แก้ไขกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);      

        // 05/06 Show form to edit
        }elseif( $task === "edit"){
            $coursetype = $coursetype_model->get_by_id($id);

            $data["coursetype_id"] = $id;
            $data["coursetype_name"] = $coursetype->coursetype_name;
            
            $data["page_title"] = 	"แก้ไขกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);            

        // 06/06 Show new form
        }elseif( $task === "new" ){

            $data["page_title"] = 	"เพิ่มกลุ่มวิชา ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);      
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

