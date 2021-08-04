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

    public function showAll(){

        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DateTimeModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;

        $arr_post = $post_model->get_all_row();
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

}

