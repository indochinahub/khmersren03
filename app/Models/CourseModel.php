<?php

namespace App\Models;

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

}


