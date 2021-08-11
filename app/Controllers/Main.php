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
use App\Models\MediaModel;
use App\Models\DateTimeModel;
use App\Models\PostcategoryModel;


class Main extends MyController
{


	public function index(){

        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DateTimeModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;

		// Post Section
        $arr_post = $post_model->get_all_row();
        $arr_post = $util_model->sort_array_of_object_by_the_property( 
						$arr_post, 
						$sorted_property = "post_id", 
						$order_by ="desc"
					);
		$arr_post = array_slice( $arr_post, 0, 3);

        $data["arr_post"] = [];
        foreach( $arr_post as $post){

            $media_model        = new MediaModel( $post, "post");
            $post->post_intro   = $media_model->replace_media_tag_with_html($post->post_intro);

            $post->user = $user_model->get_by_post_id( $post->post_id );
            $post->post_createddate = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                        $post->post_createddate );
            $post->postcategory = $postcategory_model->get_by_post_id($post->post_id);
            $post->postcategory_num_card = $post_model->get_num_by_postcategory_id( $post->id_postcategory);

            //$post = $post_model->add_media_to_post($post);
            array_push( $data["arr_post"], $post);

        }

		$data["page_title"] = 	" "; 
		$data["page_link"] 	= 	[   "",
									""
							   ];
		$this->_view("index",$data);             

	}
}

