<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\PracticeModel;

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

                $assoc_media[ "[youtbube0".$key."]" ] = $html;

            }else{
                $assoc_media[ "[youtbube0".$key."]" ] = false;

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


    /*
    public function add_media_to_post( $obj_post ){}
    */


}
