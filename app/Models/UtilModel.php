<?php

use App\Models\UtilModel;
namespace App\Models;

class UtilModel
{

    public function get_class_from_fullname($full_class_name){

        $arr_name = explode( '\\', $full_class_name);
        return end($arr_name);

    }

}


