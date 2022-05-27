<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DatetimeModel;
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

    public function myFollow($member_id){

        $user_model = new UserModel;
        $follow_model = new FollowModel;
        $util_model = new UtilModel;

        // User Management
        $data["user"]   = $this->_get_loggedin_user();
        $data["member"] = $user_model->get_user_by_id($member_id);

        if( $data["user"]->user_id === $data["member"]->user_id ){
            $data["if_user_view_own_profile"] = true;
            $data["display_name"] = "ฉัน";

        }else{
            $data["if_user_view_own_profile"] = false;
            $data["display_name"] = $user_model->get_user_displayname($data["member"]);
        }

        // Who I follow
        $arr_id_of_whom_i_follow = $follow_model->get_id_of_whom_i_follow($member_id);

        $data["arr_of_whom_i_follow"] = [];
        foreach( $arr_id_of_whom_i_follow as $id ){
            $user = $user_model->get_by_id($id);
            $user->displayname = $user_model->get_user_displayname($user);
            $user->avarta_url = $user_model->get_avarta_url($user);
            array_push( $data["arr_of_whom_i_follow"], $user);
        }

        $data["arr_of_whom_i_follow"] = $util_model->sort_array_of_object_by_the_property( 
                                                $data["arr_of_whom_i_follow"], 
                                                "user_visittime", 
                                                $order_by ="desc"
                                            );

        $num_row = (int) ceil( count($data["arr_of_whom_i_follow"])/4) ;
        $data["arr_of_whom_i_follow"] = $util_model->saparate_array_to_row(
                                                $data["arr_of_whom_i_follow"],
                                                $num_row,
                                                4
                                            );

        // Who follow me
        $arr_id_of_my_follower = $follow_model->get_my_follower_id($member_id);

        $data["arr_of_my_follower"] = [];
        foreach( $arr_id_of_my_follower as $id ){
            $user = $user_model->get_by_id($id);
            $user->displayname = $user_model->get_user_displayname($user);
            $user->avarta_url = $user_model->get_avarta_url($user);
            array_push( $data["arr_of_my_follower"], $user);
        }

        $data["arr_of_my_follower"] = $util_model->sort_array_of_object_by_the_property( 
                                                $data["arr_of_my_follower"], 
                                                "user_visittime", 
                                                $order_by ="desc"
                                            );

        $num_row = (int) ceil( count($data["arr_of_my_follower"])/4) ;
        $data["arr_of_my_follower"] = $util_model->saparate_array_to_row(
                                                $data["arr_of_my_follower"],
                                                $num_row,
                                                4
                                            );

        $data["page_title"] = 	$data["display_name"]." และผู้ที่เกี่ยวข้อง ";
        $data["page_link"] 	= 	[   "หน้าที่แล้ว",
                                    $this->_get_backlink()
                                ];
        $this->_view("myFollow",$data);        
    }



}

