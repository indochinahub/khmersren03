<?php

namespace App\Models;

class LessonModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "lesson";
        $this->primaryKey = $this->table."_id";
    }

    // return array of object
    public function get_by_course_id($course_id){

        $where_clause =  " WHERE id_course = $course_id ";
        $where_clause .= " ORDER BY lesson_sort ASC ";
        return $this->get_where($where_clause);
    }

    //return url
    public function get_thumbnail_url(){
        return base_url( ["asset","media","course_media","unread_lesson_thumbnail.jpg"]);
    }


}



