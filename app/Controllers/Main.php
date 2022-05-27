<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
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
use App\Models\DatetimeModel;
use App\Models\PostcategoryModel;


class Main extends MyController
{
	public function index(){

        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DatetimeModel;
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
                                        $post->post_createtime );
            $post->postcategory = $postcategory_model->get_by_post_id($post->post_id);
            $post->postcategory_num_card = $post_model->get_num_by_postcategory_id( $post->id_postcategory);

            array_push( $data["arr_post"], $post);
        }

        // User Section
        $arr_user = $user_model->get_all_row();
        $arr_user = $util_model->sort_array_of_object_by_the_property( 
                                    $arr_user, 
                                    "user_visittime", 
                                    $order_by ="desc"
                                );
        $arr_user = array_slice($arr_user, 0, 8);

        $data["arr_user"] = [];
        foreach( $arr_user as $user){
            $user->avarta_url = $user_model->get_avarta_url($user);
            $user->displayname = $user_model->get_user_displayname($user);
            array_push( $data["arr_user"], $user);
        }

        $data["arr_user"] = $util_model->saparate_array_to_row(
                                    $data["arr_user"],
                                    2,
                                    4
                                );

        // View Section
		$data["page_title"] = 	" "; 
		$data["page_link"] 	= 	[   "",
									""
							   ];
		$this->_view("index",$data);             

	}
}

