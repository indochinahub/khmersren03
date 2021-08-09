<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\PaginationModel;
use App\Models\CardcommentModel;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\DateTimeModel;
use App\Models\PostcategoryModel;

class File extends MyController
{

    public function deletePicture($table_name, $key_id, $media_num){

        // delete real file

        // set null to database

        if( $table_name === "post" ){
            $table_model = new PostModel;
        }

        $obj = $table_model->get_by_id();

        

        echo "xxxx";

    }
}

