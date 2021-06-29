<?php

use App\Models\UtilModel;
namespace App\Models;

class UtilModel
{

    public function get_class_from_fullname($full_class_name){
        $arr_name = explode( '\\', $full_class_name);
        return end($arr_name);
    }

    // Return Object or False
    public function get_object_from_arr_object_with_pointer_by_key_id(
                                    $arr_object, $key_column, $key_id){

        if( ($arr_object == FALSE) || ($key_column == FALSE) || ($key_id == FALSE) ){return FALSE;}

        $new_arr_object = [];
        for ($i = 0; $i < count($arr_object); $i++) {
            $curren_obj = $arr_object[$i];

            if($i === 0){
                $curren_obj->previous_id = FALSE;
            }else{
                $curren_obj->previous_id = $arr_object[$i-1]->$key_column;
            }

            if($i === (count($arr_object)-1)){    
                $curren_obj->next_id = FALSE;
            }else{
                $curren_obj->next_id = $arr_object[$i+1]->$key_column;
            }

            array_push($new_arr_object,$curren_obj);
            $new_arr_object[$curren_obj->$key_column] = $curren_obj;
        }

        return $new_arr_object[$key_id];  
    }
	
    // Return Array Of Object
    public function get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object, $property_name, $text_to_compare, $operator = "=="){

        $arr_result_object = [];
        foreach($origin_arr_object as $object){

            if( $operator === "=="){
                if( $object->$property_name == $text_to_compare){   
                    array_push($arr_result_object,$object);
                }
            }
        }

        return $arr_result_object;
    }

    // Return Array
    public function get_assoc_from_array_of_object($arr_object, $key_property) {

        if($arr_object === []){ return []; }

        $assoc_object = [];
        foreach( $arr_object as $obj){
            $assoc_object[$obj->$key_property] = $obj;
            
        }
        return $assoc_object;
    }

    // return Text
    public function get_line_of_text_with_saparator_from_array($arrs, $saparator){

        $text = "";
        for ($i = 0; $i < count($arrs); $i++) {
            if( $arrs[$i] == FALSE ){ $arrs[$i] = "NULL";}

            if( $i === (count($arrs) - 1)){
                $text .= $arrs[$i];
            }else{
                $text .= $arrs[$i]."$saparator";
            }

        }
        
        return trim($text);
    }

    //  return Array 
    public function get_property_names_of_one_object_as_array($object_name){
        $property_value_assocs = get_object_vars($object_name);

        $property_names = [];
        foreach($property_value_assocs as $property=>$value){
            array_push($property_names,$property);
        }

        return $property_names;
    }





}


