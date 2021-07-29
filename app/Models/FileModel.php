<?php

namespace App\Models;

class FileModel
{
    // return true or false
    public function  create_file( $full_pathname ){
        
        if( is_file( $full_pathname )){
            return true;            

        }elseif( $my_file = fopen($full_pathname, 'w') ){
            fclose($my_file);
            return true;

        }else{
            return false;
        }
    }

    // return true or false
    public function write_to_file( $full_pathname, $text ){

        if( file_exists($full_pathname)){

            if( $my_file = fopen($full_pathname, "w") ){
                fwrite($my_file, trim($text));
                fclose($my_file);
                return TRUE;
            }
        }else{
            return false;
        }        

    }

    // return array of column and array of row
    public function get_data_from_export_file($full_pathname){

        if( ! is_file($full_pathname )){ die( "There is no file at :".$full_pathname);} 

        $text_file        =   fopen($full_pathname, "r");
        $arr_column   =   explode("\t", trim(fgets($text_file)));             
    
        $arr_row = [];
        while (!feof($text_file)) {
            
            $line = trim(fgets($text_file));
            $arr_element = explode("\t", $line);
    
            $row = new \stdClass;
            if( count($arr_element) === count($arr_column) ){
                $i = 0;
                foreach( $arr_column as $column ){
                    if( $arr_element[$i] ) { 
                        $row->$column = $arr_element[$i]; 
                    }else{
                        $row->$column = "NULL"; 
                        }
                    $i = $i + 1;
                }                    
                array_push( $arr_row, $row);
    
            }else{
                die( "Not equal!" );
            }
        }

        $result = new \stdClass;
        $result->arr_column = $arr_column ;
        $result->arr_row    = $arr_row ;

        return $result;
    }
    

}


