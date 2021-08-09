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

    // return array of picture
    public function get_arr_picture(){

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

    // return array of sound
    public function get_arr_sound(){

        $obj = $this->obj;
        $sound_key    = ["1","2"];

        $arr_sound = [];

        foreach($sound_key as $key){
            $sound = new \stdClass;
            $property = $this->table_name."_sound0".$key;
            if( isset($obj->$property) && $obj->$property ){

                $sound->media_tag = "[sound0".$key."]";

                $html =  "<div>";
                $html .= "<audio controls=''>";
                $html .= "<source src='".base_url([ "asset","media",$this->table_name."_media", $obj->$property ])."' type='audio/mpeg'>";
                $html .= "</audio><br>";
                $html .= "<a href='".base_url([ "asset","media",$this->table_name."_media", $obj->$property ])."'>[ Listen Directly ]</a>";
                $html .= "</div>";
                $sound->html = $html;
                
                $sound->property = $property;
                $sound->value = $obj->$property;
                array_push( $arr_sound, $sound);
            }
        }
        
        return $arr_sound;
    }

    // return array of youtube
    public function get_arr_youtube(){

        $obj = $this->obj;
        $youtube_key    = ["1","2","3","4"];        
        $arr_youtube = [];
        foreach($youtube_key as $key){
            $youtube = new \stdClass;
            $property = $this->table_name."_youtube0".$key;
            if( isset($obj->$property) && $obj->$property ){

                $youtube->media_tag = "[youtube0".$key."]";

                $html =     "<div style='margin-bottom:15px'>";
	            $html .=    "<div class='embed-responsive embed-responsive-16by9'>";
                $html .=    "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$obj->$property."' allowfullscreen=''></iframe>";
                $html .=    "</div>";
                $html .=    "</div>";

                $youtube->html = $html;
                
                $youtube->property = $property;
                $youtube->value = $obj->$property;
                array_push( $arr_youtube, $youtube);
            }

        }

        return $arr_youtube;
    }

    // return text
    public function replace_media_tag_with_html($text){

        $arr_media = $this->get_arr_picture();
        $arr_media = array_merge($arr_media, $this->get_arr_sound());
        $arr_media = array_merge($arr_media, $this->get_arr_youtube());

        foreach( $arr_media as $media ){

            $text = str_replace( $media->media_tag, $media->html , $text );
        }

        return nl2br($text);

    }







}
