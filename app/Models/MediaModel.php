<?php

namespace App\Models;

class MediaModel 
{
    var $arr_picture;
    var $arr_sound;
    var $arr_youtube;
    var $table_name;
    var $obj;

    public function __construct($obj, $table_name){

        $this->table_name = $table_name;
        $this->obj = $obj;


    }

    // return array of text
    public function get_arr_picture(){

        // get picture media
        $obj = $this->obj;
        $picture_key    = ["1","2","3","4","5","6"];

        $arr_picture = [];
        foreach($picture_key as $key){
            $picture = new \stdClass;

            $property = $this->table_name."_picture0".$key;
            if( isset($obj->$property) && $obj->$property ){

                $picture->media_tag = "[picture0".$key."]";

                $html =  "<div style='border:1px solid black'>";
                $html .= "<img src='".base_url(["asset","media", $this->table_name."_media", $obj->$property])."' class='img-fluid'>";
                $html .=  "</div>";
                $picture->html = $html;
                
                $picture->property = $property;
                $picture->value = $obj->$property;
                array_push( $arr_picture, $picture);
            }
        }
        
        return $arr_picture;

    }







}
