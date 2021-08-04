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
    


}
