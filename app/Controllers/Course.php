<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;

class Course extends MyController
{

	public function showAll() {

        $coursetype_model = new CourseTypeModel();
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

                /*
                echo "coursetype id :: $coursetype->coursetype_id <br>";
                echo "num of course :: ".count($arr_course_of_coursetype)."<br>";
                echo "<hr>";
                var_dump($arr_course_as_row);
                echo "<hr>";
                */

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

        if( $data["loggedin_user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["course"] = $course_model->get_by_id($course_id);
        $data["arr_deck"] = $deck_model->get_by_course_id($course_id);

        
        $data["page_title"] = 	"วิชา ".$data["course"]->course_code." ".$data["course"]->course_name;
        $data["page_link"] 	= 	[ "All Courses", base_url(["Course","showAll"])];	        
        $this->_view("show",$data);
        

    }


}

