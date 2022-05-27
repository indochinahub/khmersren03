<?php

namespace App\Models;

use App\Models\DeckModel;
use App\Models\CourseModel;
use App\Models\CardgroupModel;

class CourseModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "course";
        $this->primaryKey = $this->table."_id";
    }

    // return Object Or FALSE
    public function get_by_cardgroup_id($cardgroup_id){

        $cardgroup_model = new CardgroupModel;
        $course_model = new CourseModel;

        if( !($cardgroup = $cardgroup_model->get_by_id($cardgroup_id))){return false;}
        if( !( $course = $this->get_by_id($cardgroup->id_course))){return false;}

        return $course;
    }

    // return object or false
    public function get_by_deck_id($deck_id){
        $deck_model = new DeckModel;
        $course_model = new CourseModel;

        if( !( $deck = $deck_model->get_by_id($deck_id) )){ return false;}
        if( !( $course = $this->get_by_cardgroup_id($deck->id_cardgroup))){return false;}

        return $course;
    }

    //return array_of_object
    public function get_by_coursetype_id($coursetype_id){
        
        $where_clause = " WHERE id_coursetype = $coursetype_id ";
        if( $arr_course = $this->get_where($where_clause) ){
            return $arr_course;

        }else{
            return [];

        }
    }

    //return url
    public function get_thumbnail_url($file_name){

        if($file_name){
            return base_url( ["asset","media","course_media",$file_name]);
        }else{
            return base_url( ["asset","media","course_media","default_course_thumbnail.jpg"]);
        }

    }

}


