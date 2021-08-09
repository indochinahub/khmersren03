<?php

namespace App\Models;

class PostModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "post";
        $this->primaryKey = $this->table."_id";
    }

    // return assoc_array
    public function get_assoc_media_html($obj_post){

        $assoc_media = [];

        // get picture media
        $picture_key    = ["1","2","3","4","5","6"];
        foreach($picture_key as $key){
            $property = "post_picture0".$key;
            if( $obj_post->$property ){
                $html =  "<div style='border:1px solid black'>";
                $html .= "<img src='".base_url(["asset","media","post_media", $obj_post->$property])."' class='img-fluid'>";
                $html .=  "</div>";
                $assoc_media[ "[picture0".$key."]" ] = $html;

            }else{
                $assoc_media[ "[picture0".$key."]" ] = false;

            }
        }

        // get youtube media
        $youtube_key      = [ "1","2","3","4"];
        foreach($youtube_key as $key){
            $property = "post_youtube0".$key;
            if( $obj_post->$property ){

                $html =     "<div style='margin-bottom:15px'>";
	            $html .=    "<div class='embed-responsive embed-responsive-16by9'>";
                $html .=    "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$obj_post->$property."' allowfullscreen=''></iframe>";
                $html .=    "</div>";
                $html .=    "</div>";

                $assoc_media[ "[youtube0".$key."]" ] = $html;

            }else{
                $assoc_media[ "[youtube0".$key."]" ] = false;

            }
        }

        $sound_key      = [ "1","2"];
        foreach($sound_key as $key){
            $property = "post_sound0".$key;
            if( $obj_post->$property ){

                $html =  "<div>";
                $html .= "<audio controls=''>";
                $html .= "<source src='".base_url([ "asset","media","post_media", $obj_post->$property ])."' type='audio/mpeg'>";
                $html .= "</audio><br>";
                $html .= "<a href='".base_url([ "asset","media","post_media", $obj_post->$property ])."'>[ Listen Directly ]</a>";
                $html .= "</div>";

                $assoc_media[ "[sound0".$key."]" ] = $html;

            }else{
                $assoc_media[ "[sound0".$key."]" ] = false;
            }
        }        
        return $assoc_media;
    }

    // return array_of_object
    public function get_by_postcategory_id($postcategory_id){
        
        $where_clause = " WHERE id_postcategory = $postcategory_id ";
        return $this->get_where($where_clause);
    }

    // return int
    public function get_num_by_postcategory_id($postcategory_id){

        $sql =  " SELECT COUNT(post_id) AS num_post FROM post ";
        $sql .= " WHERE id_postcategory =  $postcategory_id ";

        $query = $this->query($sql);

        if( $result = $query->getResult() ){
            return (int) $result[0]->num_post;

        }else{
            return 0;
        }




    }

    // return array of object
    public function get_by_user_id($user_id){

        $postcategory_model = new PostcategoryModel;

        if(!($arr_postcategory = $postcategory_model->get_by_user_id($user_id))){return [];}

        $arr_post = [];
        foreach( $arr_postcategory as $postcategory ){
            $arr_post_by_category = $this->get_by_postcategory_id($postcategory->postcategory_id);
            $arr_post = array_merge($arr_post,$arr_post_by_category);
        }

        return $arr_post;
    }


    


}
