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

        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["course"] = $course_model->get_by_id($course_id);
        $arr_deck = $deck_model->get_by_course_id($course_id);

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


}

