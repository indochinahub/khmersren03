<?php

namespace App\Models;

class PostModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "post";
        $this->primaryKey = $this->table."_id";
    }

    // return array_of_object
    public function get_by_postcategory_id($postcategory_id){
        
        $where_clause = " WHERE id_postcategory = $postcategory_id ";
        return $this->get_where($where_clause);
    }

    // return int
    public function get_num_by_postcategory_id($postcategory_id){

        $sql =  " SELECT COUNT(post_id) AS num_post FROM post ";
        $sql .= " WHERE id_postcategory =  $postcategory_id ";

        $query = $this->query($sql);

        if( $result = $query->getResult() ){
            return (int) $result[0]->num_post;

        }else{
            return 0;
        }
    }

    // return array of object
    public function get_by_user_id($user_id){

        $postcategory_model = new PostcategoryModel;

        if(!($arr_postcategory = $postcategory_model->get_by_user_id($user_id))){return [];}

        $arr_post = [];
        foreach( $arr_postcategory as $postcategory ){
            $arr_post_by_category = $this->get_by_postcategory_id($postcategory->postcategory_id);
            $arr_post = array_merge($arr_post,$arr_post_by_category);
        }

        return $arr_post;
    }

}
