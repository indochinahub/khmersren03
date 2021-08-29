<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\LessonModel;
class Course extends MyController
{

	public function showAll() {

        $coursetype_model = new CoursetypeModel();
        $course_model = new CourseModel();
        $util_model = new UtilModel();

        $arr_course_origin = $course_model->get_all_row();
        $arr_course = [];
        foreach( $arr_course_origin as $course){
            $course->icon_url = $course_model->get_icon_url($course);
            array_push($arr_course,$course);
        }

        $arr_coursetype = $coursetype_model->get_all_row();

        $data["arr_coursetype"] = [];
        foreach( $arr_coursetype as $coursetype){

            $arr_course_of_coursetype = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_course, 
                            $property_name = "id_coursetype", 
                            $text_to_compare = $coursetype->coursetype_id, 
                            $operator = "==");

            if( count($arr_course_of_coursetype) > 0 ){

                $arr_course_as_row = $this->util_model->separate_array_to_pair_value($arr_course_of_coursetype);

                $coursetype->arr_course_as_row = $arr_course_as_row;
                array_push($data["arr_coursetype"],$coursetype);
            }
    
        }

        $data["page_title"] = 	"วิชาทั้งหมด";
        $data["page_link"] 	= 	[	"Home",
                                    base_url()
                                ];	        
        $this->_view("showAll",$data);

	}

    public function show($course_id){

        $course_model = new CourseModel;
        $deck_model = new DeckModel;
        $card_model = new CardModel;
        $practice_model = new PracticeModel;
        $util_model = new UtilModel;
        $user_model = new UserModel;
        $lesson_model = new LessonModel;

        $data = [];
        if( ( $data["user"] = $this->_get_loggedin_user()) && 
              $data["user"]->user_level === "3" ){

            $data["if_user_is_adamin"] = true;
        }else{
            $data["if_user_is_adamin"] = false;
        }

        $data["course"] = $course_model->get_by_id($course_id);
        $arr_deck = $deck_model->get_by_course_id($course_id);

        if( $data["user"] ){  

            $data["arr_deck"] = [];
            foreach( $arr_deck as $deck){

                $deck->num_all_card = count($card_model->get_by_deck_id($deck->deck_id));
                $arr_practice = $practice_model->get_by_deck_id_user_id(
                                                        $deck->deck_id, 
                                                        $data["user"]->user_id);
                $deck->num_user_card = count( $arr_practice );
                $deck->card_to_review_today = count(    $practice_model->get_to_review(
                                                            $deck_id = $deck->deck_id, 
                                                            $user_id = $data["user"]->user_id, 
                                                            $unix_timestamp = time(), 
                                                            $next_day = 0 )
                                                    );
                $deck->card_to_review_tomorrow = count(    $practice_model->get_to_review(
                                                        $deck_id = $deck->deck_id, 
                                                        $user_id = $data["user"]->user_id, 
                                                        $unix_timestamp = time(), 
                                                        $next_day = 1)
                                                    );  
                $deck->avarage_card_interval = (int) $util_model->get_average_property_of_arr_object( 
                                                        $arr_object = $arr_practice, 
                                                        $property = "practice_intervalDay"
                                                    );
            array_push( $data["arr_deck"], $deck);
            }

        }else{
            $data["arr_deck"] = [];
        }

        // Display User Visited
        $arr_visited_user = $user_model->get_last_visit_user_of_course($course_id, $num = 4);

        $data["arr_user_to_show"] = [];
        foreach( $arr_visited_user as $user ){

            $user->displayname = $user_model->get_user_displayname($user);
            $user->avarta_url = $user_model->get_avarta_url($user->user_id);            
            array_push( $data["arr_user_to_show"], $user);
        }

        $data["arr_user_to_show"] = $util_model->saparate_array_to_row(
                                            $data["arr_user_to_show"],
                                            1,
                                            4
                                        );

        // Show Lesson
        $data["arr_lesson"] = $lesson_model->get_by_course_id($course_id);

        // View Section
        $data["page_title"] = 	"วิชา ".$data["course"]->course_code." ".$data["course"]->course_name;
        $data["page_link"] 	= 	[ "All Courses", base_url(["Course","showAll"])];	        
        $this->_view("show",$data);
    }

    public function addEdit($task,$id = "0"){

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

        // Set the task and validate form
        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit"  ){

            $data["task"] = "update";

        }elseif( $task === "edit"){

            $data["task"] = "show_form_to_update";

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){
            $data["task"] = "insert";

        }elseif( $task === "new" ){
            $data["task"] = "show_form_to_insert";
        }

        // Do the task
        if( $data["task"] === "show_form_to_update" ){

            $data["course"] = $course_model->get_by_id($id);

            $arr_coursetype = $coursetype_model->get_all_row();
            $data["arr_coursetype"] = [];
            foreach( $arr_coursetype as $coursetype){

                if( $data["course"]->id_coursetype == $coursetype->coursetype_id ){
                    $coursetype->selected_text = "selected";
                }else{
                    $coursetype->selected_text = "";
                }
                array_push($data["arr_coursetype"],$coursetype);
            }

            //die();

            // View Section
            $data["page_title"] = 	"แก้ไขวิชา ";
            $data["page_link"] 	= 	[ "กลับ", $this->_get_backlink() ];
            $this->_view("addEdit",$data);     

        }elseif( $data["task"] === "update"){

            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);

            $course_model->update_by_id($id, $detail);

            return redirect()->to(base_url(["Course","show", $id]));		


        }elseif( $data["task"] === "show_form_to_insert"){

            $arr_coursetype = $coursetype_model->get_all_row();
            $data["arr_coursetype"] = [];
            foreach( $arr_coursetype as $key => $coursetype){
                if( $key === 0){
                    $coursetype->selected_text = "selected";
                }else{
                    $coursetype->selected_text = "";
                }
                array_push($data["arr_coursetype"],$coursetype);
            }

            $data["course"] = $course_model->get_object_with_null_value();

            $data["page_title"] = 	"เพิ่ม ";
            $data["page_link"] 	= 	[ "กลับ", $this->_get_backlink() ];
            $this->_view("addEdit",$data);     

        }elseif( $data["task"] === "insert"){

            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);

            $course_id = $course_model->insert($detail);
            return redirect()->to(base_url(["Course","showAll"]));
            
        }
    }

    public function delete($course_id, $confirm = "0"){

        echo "delete";

    }

    


}

