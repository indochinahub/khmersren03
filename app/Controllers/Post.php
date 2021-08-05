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

class Post extends MyController
{
    public function showBy($groupBy = "All", $id = "0"){

        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DateTimeModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;

        if( $groupBy === "All" ){
            $arr_post = $post_model->get_all_row();

        }elseif( $groupBy === "User"){
            
            $data["member"] = $user_model->get_user_by_id($id);
            $arr_post = $post_model->get_by_user_id($id);
        }

        $arr_post = $util_model->sort_array_of_object_by_the_property( 
            $arr_post, 
            $sorted_property = "post_id", 
            $order_by ="desc"
        );


        // Pagination
        if( ! ($page = $this->request->getGet('page')) ){
            $page = 1;
        }

        $pagination = $pagination_model->get_pagination( 
                                        $arr_post, 
                                        $current_page = $page , 
                                        $per_page = 10
                                    );
        $data["pagination_link"] = $pagination->link;
        $arr_post = $pagination->arr_row; 


        $data["arr_post"] = [];
        foreach( $arr_post as $post){
            $post->user = $user_model->get_by_post_id( $post->post_id );
            $post->post_createddate = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                        $post->post_createddate );
            $post->postcategory = $postcategory_model->get_by_post_id($post->post_id);
            $post->postcategory_num_card = $post_model->get_num_by_postcategory_id( $post->id_postcategory);
            

            $post = $post_model->add_media_to_post($post);
            array_push( $data["arr_post"], $post);

        }

        $data["page_title"] = 	"บทความ :: ทั้งหมด "; 
        $data["page_link"] 	= 	[   "หน้าแรก ",
                                    base_url()
                               ];
                               
        $this->_view("showAll",$data);                
    }

    public function show($post_id){

        $post_model = new PostModel;
        $user_model = new UserModel;
        $postcategory_model = new PostcategoryModel;
        $datetime_model = new DateTimeModel;

        $data["post"]                   = $post_model->get_by_id($post_id);
        $data["post"]                   = $post_model->add_media_to_post($data["post"]);

        $data["owner"]                  = $user_model->get_by_post_id($data["post"]->post_id);
        $data["postcategory"]           = $postcategory_model->get_by_post_id($data["post"]->post_id);
        $data["postcategory_num_card"]  = $post_model->get_num_by_postcategory_id($data["post"]->id_postcategory);
        $data["post_createddate"]       = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                            $data["post"]->post_createddate );

        if( isset( $_SERVER['HTTP_REFERER'] ) ){
            $data["back_link"] = $_SERVER['HTTP_REFERER'];
        }else{
            $data["back_link"] = base_url();
        }

        $data["page_title"] = 	""; 
        $data["page_link"] 	= 	[   " ",
                                    base_url()
                               ];
        $this->_view("show",$data);                        
    }

}

