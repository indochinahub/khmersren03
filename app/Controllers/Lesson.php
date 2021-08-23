<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
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
use App\Models\DateTimeModel;
use App\Models\PostcategoryModel;
use App\Models\LessonModel;

class Lesson extends MyController
{

    public function addEdit($task,$id = "0"){

        $post_model         = new PostModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;
        $util_model         = new UtilModel;
        $datetime_model     = new DateTimeModel;
        $lesson_model       = new LessonModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        // Set the task and validate form
        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit"  ){
            //$data["task"] = "update";

        }elseif( $task === "edit"){

            /*
            $data["post"] = $post_model->get_by_id($post_id);

            $owner = $user_model->get_by_post_id($post_id);
            if( $user->user_id === $owner->user_id ){
            }else{
                $this->_needPrivilege();
                return;
            }

            $data["task"] = "show_form_to_update";
            */

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){
            $data["task"] = "insert";

        }elseif( $task === "new" ){
            $data["task"] = "show_form_to_insert";
        }


        // Do the task
        if( $data["task"] === "show_form_to_update" ){

            /*
            // get arr_postcategory
            $data["arr_postcategory"] = [];
            foreach( $arr_postcategory as $postcategory){

                if( $postcategory->postcategory_id == $data["post"]->id_postcategory ){
                    $postcategory->checked_text = " checked ";

                }else{
                    $postcategory->checked_text = "";
                }
                array_push( $data["arr_postcategory"], $postcategory);
            }
            
            $media_model            = new MediaModel( $data["post"], "post");
            $data["arr_picture"]    = $media_model->get_arr_picture();
            $data["arr_sound"]      = $media_model->get_arr_sound();
            $data["arr_youtube"]    = $media_model->get_arr_youtube();
            $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");
            $data["first_vacant_sound"] = $media_model->get_first_vacant_picture_slot("sound");
            $data["first_vacant_youtube"] = $media_model->get_first_vacant_picture_slot("youtube");

            $data["page_title"] = 	"Edit :: ".$data["post"]->post_id; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);
            */
            

        }elseif( $data["task"] === "update"){

            /*
            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);
            $detail["post_publisheddate"] = $datetime_model->unix_timestamp_to_sql_timestamp(time());

            $post_model->update_by_id($post_id, $detail);

            return redirect()->to(base_url(["Post","show", $post_id]));		
            */


        }elseif( $data["task"] === "show_form_to_insert"){

            $data["lesson"] = $lesson_model->get_object_with_null_value();
            $data["course_id"] = $id;

            $data["page_title"] = 	"Add new lesson "; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);                         

        }elseif( $data["task"] === "insert"){

            $detail = $this->request->getPost();
            $detail["id_course"] = $id;

            $detail = $util_model->fill_null_in_array($detail);
            
            $lesson_id = $lesson_model->insert($detail);

            return redirect()->to(base_url(["Lesson","show",$lesson_id]));            

        }        

    }


    public function show($lesson_id){
        echo "Hello";


    }


    

}

