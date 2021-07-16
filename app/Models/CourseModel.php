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

    // return URL text
    public function get_icon_url($course_obj){

        if(file_exists(ASSETPATH."/course/".$course_obj->course_code."/course_thumbnail.jpg")){
            return base_url(["asset","course",$course_obj->course_code,"course_thumbnail.jpg"]);    

        }else{
            return base_url(["asset","course","course_thumbnail.jpg"]);    
        }
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


}


