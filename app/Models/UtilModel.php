<?php

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
            }elseif( $operator === ">" ){
                if( $object->$property_name > $text_to_compare){   
                    array_push($arr_result_object,$object);
                }
            }elseif( $operator === ">=" ){
                if( $object->$property_name >= $text_to_compare){   
                    array_push($arr_result_object,$object);
                }
            }elseif( $operator === "<" ){
                if( $object->$property_name < $text_to_compare){   
                    array_push($arr_result_object,$object);
                }
            }elseif( $operator === "<=" ){
                if( $object->$property_name <= $text_to_compare){   
                    array_push($arr_result_object,$object);
                }
            }elseif( $operator === "!=" ){
                if( $object->$property_name != $text_to_compare){   
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

    //  return Array 
    public function get_property_value_Of_many_objects_as_array($array_of_objects,$property){

        $array_of_object_property = [];
        foreach($array_of_objects as $object){
            array_push($array_of_object_property, $object->$property);
        }

        return $array_of_object_property;
    }    

    //  return Array 
    public function get_property_values_of_one_object_as_array($object_name){
        $property_value_assocs = get_object_vars($object_name);

        $property_values = [];
        foreach($property_value_assocs as $property=>$value){
            array_push($property_values,$value);
        }

        return $property_values;
    }

    // Return array of ojbect
    public function sort_array_of_object_by_the_property( $objects, $sorted_property, $order_by ="asc"){

        if( $objects == []){ return [];}

        $i = 0 ;
        $object_key_and_object_assoc = [];
        $object_key_and_sorted_property_assoc = [];
        foreach($objects as $object){
            $object_key_and_object_assoc[$i] = $object;
            $object_key_and_sorted_property_assoc[$i] = $object->$sorted_property;
            $i++;
        }

        if($order_by === "asc"){
            asort($object_key_and_sorted_property_assoc);    
        }elseif($order_by === "desc") {
            arsort($object_key_and_sorted_property_assoc);    
        }
        
        $sorted_objects = [];
        foreach($object_key_and_sorted_property_assoc as $key=>$value){
            array_push($sorted_objects,$object_key_and_object_assoc[$key] );
        }

        return $sorted_objects;
    }

    // return int or zero
    public function get_average_property_of_arr_object( $arr_object, $property){
        if( $arr_object === []){ return [];}

        $num_object = count($arr_object);
        $sum = 0;
        foreach( $arr_object as $object ){
            $sum = $sum + ((float) $object->$property);
        }

        return $sum/$num_object;
    }

    // return float or zero
    public function get_sum_property_of_arr_object( $arr_object, $property){
        if( $arr_object === []){ return [];}

        $sum = 0;
        foreach( $arr_object as $object ){
            $sum = $sum + ((float) $object->$property);
        }

        return $sum;
        
    }

    // Return text
    public function add_leading_zero_to_number( $text, $num_required_digit){

        $text = strval($text);
        $zero_string_to_add = (int)$num_required_digit - strlen($text) ;
    
        if($zero_string_to_add <= 0){ return $text;}
    
        for($i = 1; $i <= $zero_string_to_add;$i++ ){
            $text = "0".$text;
        }
    
        return $text; 


    }

    //return array of pair values
    public function separate_array_to_pair_value($origin_arr){

        if( count($origin_arr) === 0){ return [];}

        $new_arr = [];
        do {
            if( count($origin_arr) > 1  ){  
                array_push( $new_arr , [ array_shift($origin_arr),  array_shift($origin_arr)] );
            }else{
                array_push( $new_arr , [ array_shift($origin_arr),  false] );

            }
            
        } while (count($origin_arr) > 0);

        return $new_arr;

    }

    // return array_of_text
    public function get_line_of_text_from_array ($arr_text, $saparator ){

        if( $arr_text == [] || $saparator == ""){
            return "";
        }

        $line = "";
        foreach( $arr_text as $text ){
            $text = $this->sanitize_text_to_export($text);
            $line = $line.$text.$saparator;
        }

        return substr($line,0,-1);
    }

    // return text
    public function get_text_data_from_array_of_object($arr_object,$arr_column){
        //$arr_object,
        if( ($arr_object === []) || ( $arr_column === []) ){return "";}

        $txt_data  = "";
        foreach( $arr_object as $obj ){
    
            $line_row = "";
            foreach( $arr_column as $column ){
                if( $obj->$column){

                    $obj->$column = $this->sanitize_text_to_export($obj->$column);
                    $line_row = $line_row.$obj->$column."\t";
                }else{
                    $line_row = $line_row."NULL"."\t";
                }
            }
            // remove "\t"
            $line_row = substr( $line_row,0,-1 )."\n";
            $txt_data  = $txt_data.$line_row ;
        }

        return trim($txt_data);
    }

    // return array
    public function fill_null_in_array( $arr ){
        if( $arr === [] ){
            return [];
        }

        $new_arr = [];
        foreach( $arr as $key=>$value ){
            if( $value = trim($value) ){
                $new_arr[$key] = $value;
            }else{
                $new_arr[$key] = null;
            }
        }

        return $new_arr;

    }

    // return array of array
    public function saparate_array_to_row($arr_source,$num_row,$num_per_row){

        if( $arr_source === []){ return []; }

        $exact_num_row =  ceil(count($arr_source) / $num_per_row) ;
        if( $exact_num_row < $num_row){
            $num_row = $exact_num_row;
        }

        $arr_new = [];
        for($row = 1;$row < $num_row + 1;$row++){
            $arr_in_row = [];
            for($col = 1;$col < $num_per_row + 1;$col++){
                $obj = array_shift($arr_source);
                if( $obj ){ 
                    array_push($arr_in_row, $obj);
                }else{
                    array_push($arr_in_row, false);
                }
            }
            array_push( $arr_new ,$arr_in_row);
        }
        
        return $arr_new;        





    }

    // return object or false
    public function get_object_model_from_table_name($table_name){

        if( $table_name  ){
            $class = "App\Models\\".ucfirst($table_name)."Model"; 
            return new $class();

        }else{
            return false;

        }
    }

    // return sanitized text
    public function sanitize_text_to_export($text){
        
        $text =  str_replace( "\r\n","[newline]",$text);
        $text =  str_replace( "\n","[newline]",$text);
        return $text;
    }

    // return sanitized text
    public function sanitize_text_to_import($text){

        return str_replace( "[newline]","\r\n",$text);
    }

    // return random number or false
    public function get_random_number($num_digit){

        if($num_digit < 1 or $num_digit > 6){ return false;}

        $number = rand( 100000, 999999);
        return substr($number, -$num_digit);
    }

    

}


