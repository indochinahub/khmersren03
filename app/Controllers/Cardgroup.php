<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\DatetimeModel;
use App\Models\CardcommentModel;
use App\Models\UserModel;
use App\Models\CardgroupModel;


class Cardgroup extends MyController
{
 
    public function manage(){

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $cardgroup_model = new CardgroupModel;
        
        $arr_cardgroup = $cardgroup_model->get_all_row();

        $data["arr_cardgroup"] = [];
        foreach( $arr_cardgroup as $cardgroup){
            array_push($data["arr_cardgroup"],$cardgroup);
        }

        $data["page_title"] = 	"จัดการกลุ่มบัตรคำ"; 
        $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                    base_url(["Admin", "dashboard"])
                               ];	        
        $this->_view("manage",$data);                
    }

    public function addEdit($task,$id = "0"){

        $cardgroup_model = new CardgroupModel;
        $course_model = new CourseModel;    
        
        // 01/06 Validation Rules and Default Value 
        $arr_course = $course_model->get_all_row();
        $validattion_rules = 	[ 'cardgroup_name' => 'required|min_length[4]|max_length[80]' ];            
        
        $data["cardgroup_id"] = "";
        $data["cardgroup_name"] = "";
        $data["cardgroup_description"] = "";

        // 02/06 Update data
        if( ($this->request->getMethod() === "post") && $task === "edit" &&
             $this->validate($validattion_rules) 
          ){

            $detail = [
                "cardgroup_name"=>$this->request->getPost("cardgroup_name"),
                "cardgroup_description"=>$this->request->getPost("cardgroup_description"),
                "id_course"=>$this->request->getPost("id_course"),
            ];

            $cardgroup_model->update_by_id($id,$detail);
            return redirect()->to(base_url(["Cardgroup","manage"]));	

        // 03/06 Insert data
        }elseif( ($this->request->getMethod() === "post") && ($task === "new") &&
            $this->validate($validattion_rules) 
          ){
            
            $detail =   [
                "cardgroup_name"=>$this->request->getPost("cardgroup_name"),
                "cardgroup_description"=>$this->request->getPost("cardgroup_description"),
                "id_course"=>$this->request->getPost("id_course"),
            ];
            $cardgroup_model->insert($detail);
            return redirect()->to(base_url(["Cardgroup","manage"]));	

        // 04/06 Show form with error
        }elseif(($this->request->getMethod() === "post") ){

            $data["arr_course"] = [];
            foreach( $arr_course as $course){
                $course->selected_text = "";
                array_push($data["arr_course"],$course);
            }

            $data["cardgroup_name"] = $this->request->getPost("cardgroup_name");
            $data["cardgroup_description"] = $this->request->getPost("cardgroup_description");

            $data["cardgroup_name_error"] = $this->validator->getError('cardgroup_name');

            $data["page_title"] = 	"แก้ไขกลุ่มบัตรคำ ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);                  

        // 05/06 Show form to edit
        }elseif( $task === "edit"){

            $cardgroup = $cardgroup_model->get_by_id($id);

            $data["arr_course"] = [];
            foreach( $arr_course as $course){

                if( $cardgroup->id_course == $course->course_id ){
                    $course->selected_text = "selected";
                }else{
                    $course->selected_text = "";
                }
                array_push($data["arr_course"],$course);
            }

            $data["cardgroup_id"] = $cardgroup->cardgroup_id;
            $data["cardgroup_name"] = $cardgroup->cardgroup_name;
            $data["cardgroup_description"] = $cardgroup->cardgroup_description;

            $data["page_title"] = 	"แก้ไขกลุ่มบัตรคำ ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);             

        // 05/05 Show new form
        }elseif( $task === "new" ){
            
            $data["arr_course"] = [];
            foreach( $arr_course as $course){
                $course->selected_text = "";
                array_push($data["arr_course"],$course);
            }

            $data["page_title"] = 	"เพิ่มกลุ่มบัตรคำ ";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("addEdit",$data);             
        }
    }

    public function delete($id, $confirm = "0"){

        /*
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

        */

        

    }



}

