<?php

namespace App\Models;

class FollowModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "follow";
        $this->primaryKey = $this->table."_id";
    }

    //return array of id
    public function get_my_follower_id($user_id){

        $util_model = new UtilModel;

        $where_clause = " WHERE id_user = $user_id ";
        if( $arr_follow = $this->get_where($where_clause)){

            $arr_id = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_follow,
                                    "id_follower_of_user"
                                );
            return $arr_id;

        }else{
            return [];
        }
    }
    
    



    //return array of id
    public function user_id_of_whom_i_follow($user_id){

    }

    //return 
    public function get_my_relation_with_user($my_id,$user_id){

    }

    // return InsertedId
    public function follow_the_user($my_id, $user_id){

    }

    // return AffectedRow
    public function unfollow_the_user($my_id, $user_id){

    }


}



