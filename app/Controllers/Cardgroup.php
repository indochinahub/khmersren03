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

        $validattion_rules = 	[ 'cardgroup_name' => 'required|min_length[4]|max_length[80]' ];            
        
        // Set task
        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit" &&
             $this->validate($validattion_rules) 
          ){
            $data["task"] = "update";

        }elseif(($this->request->getMethod() === "post") && $task === "edit"){
            //$data["task"] = "show_form_error";
        
        }elseif( $task === "edit"){
            $data["task"] = "show_form_to_edit";

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){

            //$data["task"] = "insert";

        }elseif( $task === "new" ){
            //$data["task"] = "show_form_to_insert";
        }



        // Do the task
        if( $data["task"] === "show_form_to_edit" ){

            $cardgroup = $cardgroup_model->get_by_id($id);

            $arr_course = $course_model->get_all_row();
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

        }elseif( $data["task"] === "show_form_error"){

        }elseif( $data["task"] === "update" ){

            $detail = [
                        "cardgroup_name"=>$this->request->getPost("cardgroup_name"),
                        "cardgroup_description"=>$this->request->getPost("cardgroup_description"),
                        "id_course"=>$this->request->getPost("id_course"),
                    ];

            $cardgroup_model->update_by_id($id,$detail);
            return redirect()->to(base_url(["Cardgroup","manage"]));	

        }elseif( $data["task"] === "show_form_to_insert" ){

        }elseif( $data["task"] === "insert" ){

        }







    }

}

