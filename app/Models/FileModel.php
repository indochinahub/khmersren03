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

}


