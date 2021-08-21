<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DateTimeModel;
use \App\Models\UtilModel;
use \App\Models\PostModel;
use \App\Models\MediaModel;
use \App\Models\PostcategoryModel;
use \App\Models\PaginationModel;
use \App\Models\FollowModel;

class Follow extends MyController
{
    public function unfollow($my_id,$other_id){
        $follow_model = new FollowModel;

        $follow = $follow_model->get_follow_by_user_id($my_id, $other_id);

        $follow_model->delete_by_id( $follow->follow_id);

        return redirect()->to( $this->_get_backlink());		
    }


    public function follow($my_id,$other_id){

        $follow_model = new FollowModel;

        $follow_model->follow_the_other($my_id, $other_id);
        return redirect()->to( $this->_get_backlink());		
    }



}

