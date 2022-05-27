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
    public function get_my_follower_id($my_id){

        $util_model = new UtilModel;

        $where_clause = " WHERE id_user = $my_id ";
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
    public function get_id_of_whom_i_follow($my_id){

        $util_model = new UtilModel;

        $where_clause = " WHERE id_follower_of_user = $my_id ";
        if( $arr_follow = $this->get_where($where_clause)){

            $arr_id = $util_model->get_property_value_Of_many_objects_as_array(
                                    $arr_follow,
                                    "id_user"
                                );
            return $arr_id;

        }else{
            return [];
        }        
    }

    // return array of id
    public function get_id_of_whom_i_relate_to($my_id){

        $arr_id_of_my_folower = $this->get_my_follower_id($my_id);
        $arr_id_of_whom_i_follow = $this->get_id_of_whom_i_follow($my_id);

        return array_values(array_unique(array_merge($arr_id_of_my_folower, $arr_id_of_whom_i_follow )));
    }

    // return array of id
    public function get_id_of_whom_i_not_relate_to($my_id, $num){

        $util_model = new UtilModel;
        
        $sql =  " SELECT user_id FROM user WHERE 1 ";
        $sql .= " ORDER BY user_visittime desc ";
        $sql .= " LIMIT 0, 100 ";
        $query = $this->query($sql);
        $arr_user = $query->getResult();

        $arr_all_id = $util_model->get_property_value_Of_many_objects_as_array(
                                                $arr_user,
                                                "user_id" );

        $arr_id_of_my_follower = $this->get_my_follower_id($my_id);
        $arr_id_of_whom_i_follow = $this->get_id_of_whom_i_follow($my_id);

        $arr_id_of_whom_in_not_relate_to = array_diff($arr_all_id, $arr_id_of_my_follower);
        $arr_id_of_whom_in_not_relate_to = array_diff($arr_id_of_whom_in_not_relate_to, $arr_id_of_whom_i_follow);
        $arr_id_of_whom_in_not_relate_to = array_slice( $arr_id_of_whom_in_not_relate_to, 0, $num );

        return $arr_id_of_whom_in_not_relate_to;

    }

    //return relation text
    public function get_my_relation_with_other($my_id,$other_id){

        $arr_follower_of_me = $this->get_my_follower_id($my_id);
        $arr_follower_of_other = $this->get_my_follower_id($other_id);

        $arr_who_i_follow = $this->get_id_of_whom_i_follow($my_id);
        $arr_who_other_follow = $this->get_id_of_whom_i_follow($other_id);

        $relation = "xxxx";

        if( in_array( $my_id, $arr_who_other_follow) && in_array( $other_id, $arr_who_i_follow )){
            $relation = "we_folow_each_other";

        }elseif( in_array($my_id, $arr_follower_of_other ) ){
            $relation = "i_folow_the_other";

        }elseif( in_array( $other_id, $arr_follower_of_me ) ){
            $relation = "the_other_follow_me";

        }else{
            $relation = "we_have_no_relation";

        }

        return $relation;
    }

    // return InsertedId Or false
    public function follow_the_other($my_id, $other_id){

        // if there is follower in the table, do noting
        if( $this->get_follow_by_user_id($my_id, $other_id) ){ return false;}

        $detail = [ "id_user"=>$other_id,
                    "id_follower_of_user"=>$my_id
                  ];
        return $this->insert($detail);
    }

    // return object or false
    public function get_follow_by_user_id($my_id, $other_id){

        $where_clause = " WHERE id_user = $other_id AND id_follower_of_user = $my_id ";
        if($arr_follow = $this->get_where($where_clause)){ 
            return $arr_follow[0];
            
        }else{
            return false;
        }

    }


}



