<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\PaginationModel;
use App\Models\CardcommentModel;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\MediaModel;
use App\Models\DatetimeModel;
use App\Models\PostcategoryModel;
use App\Models\LessonModel;

class Lesson extends MyController
{

    public function addEdit($task,$id = "0"){

        $post_model         = new PostModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;
        $util_model         = new UtilModel;
        $datetime_model     = new DatetimeModel;
        $lesson_model       = new LessonModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $data["task"] = $task;

        // 01/06 Validation Rules and Default Value 
        $validattion_rules = 	[ 
                                    'lesson_title' => 'required|min_length[4]|max_length[100]',
                                    'lesson_content' => 'required',
                                ];            
        $data["lesson_title"]   =   "";
        $data["lesson_content"] =   "";
        $data["lesson_sort"]    =   "";

        // 02/06 Update data
        if( ($this->request->getMethod() === "post") && $data["task"] === "edit" &&
             $this->validate($validattion_rules) 
          ){

            $detail = [
                        "lesson_title"      =>  trim($this->request->getPost("lesson_title")),
                        "lesson_content"    =>  trim($this->request->getPost("lesson_content")),
                        "lesson_sort"       =>  trim($this->request->getPost("lesson_sort")),
                        "lesson_edittime"   =>  $datetime_model->unix_timestamp_to_sql_timestamp(time())
                    ];
            $lesson_model->update_by_id($id, $detail);
            return redirect()->to(base_url(["Lesson","show", $id]));	

        // 03/06 Insert data
        }elseif( ($this->request->getMethod() === "post") && ($data["task"] === "new") &&
            $this->validate($validattion_rules) 
          ){

            $detail = [
                        "lesson_title"      =>  trim($this->request->getPost("lesson_title")),
                        "lesson_content"    =>  trim($this->request->getPost("lesson_content")),
                        "lesson_sort"       =>  trim($this->request->getPost("lesson_sort")),
                        "lesson_edittime"   =>  $datetime_model->unix_timestamp_to_sql_timestamp(time()),
                        "id_course"         =>  $id
                    ];
            $lesson_id = $lesson_model->insert($detail);
            return redirect()->to(base_url(["Lesson","show",$lesson_id]));      
            
        // 04/06 Show form with error
        }elseif(($this->request->getMethod() === "post") ){

            $data["lesson"] = $lesson_model->get_by_id($id);

            $data["lesson_title"]   =   trim($this->request->getPost("lesson_title"));
            $data["lesson_content"] =   trim($this->request->getPost("lesson_content"));
            $data["lesson_sort"]    =   trim($this->request->getPost("lesson_sort"));

            $media_model            = new MediaModel( $data["lesson"], "lesson");
            $data["arr_picture"]    = $media_model->get_arr_picture();
            $data["arr_sound"]      = $media_model->get_arr_sound();
            $data["arr_youtube"]    = $media_model->get_arr_youtube();
            $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");
            $data["first_vacant_sound"] = $media_model->get_first_vacant_picture_slot("sound");
            $data["first_vacant_youtube"] = $media_model->get_first_vacant_picture_slot("youtube");            

            $data["lesson_title_error"] = $this->validator->getError('lesson_title');
            $data["lesson_content_error"] = $this->validator->getError('lesson_content');

            $data["page_title"] = 	"Edit :: ".$data["lesson"]->lesson_id; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);                  

        // 05/06 Show form to edit
        }elseif( $data["task"] === "edit"){

            $lesson = $lesson_model->get_by_id($id);

            $data["lesson_id"]      =   $id;
            $data["lesson_title"]   =   $lesson->lesson_title;
            $data["lesson_content"] =   $lesson->lesson_content;
            $data["lesson_sort"]    =   $lesson->lesson_sort;

            $media_model            = new MediaModel( $lesson, "lesson");
            $data["arr_picture"]    = $media_model->get_arr_picture();
            $data["arr_sound"]      = $media_model->get_arr_sound();
            $data["arr_youtube"]    = $media_model->get_arr_youtube();
            $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");
            $data["first_vacant_sound"] = $media_model->get_first_vacant_picture_slot("sound");
            $data["first_vacant_youtube"] = $media_model->get_first_vacant_picture_slot("youtube");

            $data["page_title"] = 	"Edit :: ".$lesson->lesson_id; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);                  

        // 06/06 Show new form
        }elseif( $data["task"] === "new" ){

            $data["page_title"] = 	"Add new lesson "; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);              
        }        
    }

    public function show($lesson_id){

        $lesson_model = new LessonModel;
        $user_model  = new UserModel;
        $course_model = new CourseModel;
        $datetime_model = new DatetimeModel;

        $data = [];
        if( ($data["user"] = $this->_get_loggedin_user())  
             && ( $data["user"]->user_level === "3")
        ){

            $data["if_user_is_admin"] = true;
        }else{

            $data["if_user_is_admin"] = false;
        }

        $data["lesson"] = $lesson_model->get_by_id($lesson_id);

        $data["lesson"]->lesson_edittime = $datetime_model->get_thai_datetime_from_sql_timestamp($data["lesson"]->lesson_edittime);

        $media_model                    = new MediaModel( $data["lesson"], "lesson");
        $data["lesson"]->lesson_content = $media_model->replace_media_tag_with_html($data["lesson"]->lesson_content);

        $data["course"] = $course_model->get_by_id( $data["lesson"]->id_course );
        
        $data["back_link"] = $this->_get_backlink();


        $data["page_title"] = 	""; 
        $data["page_link"] 	= 	[   " ",
                                    base_url()
                               ];
        $this->_view("show",$data);                        
    }

    public function delete($lesson_id, $confirm = "0"){
        
        $lesson_model = new LessonModel;

        $lesson = $lesson_model->get_by_id($lesson_id);

        if( (int)$confirm === 0 ){

            $data    =  [   "page_title"=>"ยืนยันการลบบทเรียน",
                            "what_happened"=>"คุณกำลังลบบทเรียนหมายเลข $lesson_id ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Lesson", "delete", $lesson_id, 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => $this->_get_backlink(),
                        ];  		

            $this->_view("confirm",$data);

        }else{

            $media_model = new MediaModel($lesson, "lesson");
            $media_model->delete_all_media_file();

            $lesson_model->delete_by_id($lesson_id);
            return redirect()->to(base_url( ["Course","show",$lesson->id_course]));		
        }
   
    }

}

