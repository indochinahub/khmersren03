<?php

namespace App\Models;

use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\PracticeModel;
use App\Models\PostModel;

class PostcategoryModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "postcategory";
        $this->primaryKey = $this->table."_id";
    }

    // return object or false
    public function get_by_post_id($post_id){
        
        $post_model = new PostModel;

        if( ! ($post = $post_model->get_by_id($post_id)) ){ return false;}

        return $this->get_by_id( $post->id_postcategory );
    }

    // return array of object
    public function get_by_user_id($user_id){

        if($default_postcategory = $this->get_default_postcategory($user_id)){

        }else{
            $default_postcategory_id = $this->insert_default_postcategory($user_id);
            $default_postcategory = $this->get_by_id( $default_postcategory_id );            
        }

        $arr_user_postcategory =   $this->get_user_postcategory($user_id);

        return array_merge([ $default_postcategory ],$arr_user_postcategory );
    }

    // return object or false
    public function get_default_postcategory($user_id){

        $where_clause = " WHERE id_user = $user_id AND postcategory_defaultstatus = 1 ";
        if( $default_postcatefory = $this->get_where($where_clause) ){
            return $default_postcatefory[0];

        }else{
            return false;
        }
    }

    //return array of object
    public function get_user_postcategory($user_id){

        $where_clause = " WHERE id_user = $user_id AND postcategory_defaultstatus != 1 ";
        if( $user_postcatefory = $this->get_where($where_clause) ){
            return $user_postcatefory;

        }else{
            return [];
        }        
    }

    //return insertedID  or false
    public function insert_default_postcategory($user_id){
        
        if($this->get_default_postcategory($user_id)){return false;}

        $detail = [     "postcategory_title"=>"ทั่วไป",
                        "postcategory_defaultstatus" => 1,
                        "id_user"=>$user_id, 
                ];

        return $this->insert($detail);
    }

    


}
