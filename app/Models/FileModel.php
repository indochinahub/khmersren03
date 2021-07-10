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


}


