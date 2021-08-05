<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\StatisticModel;
use App\Models\DateTimeModel;
use App\Models\PostModel;
use App\Models\PostcategoryModel;

class Profile extends MyController
{

    public function member($member_id){
        $deck_model 	 = new DeckModel;
		$course_model 	 = new CourseModel;
		$card_model 	 = new CardModel;
		$practice_model  = new PracticeModel;
		$statistic_model = new StatisticModel;
		$datetime_model  = new DateTimeModel;
		$util_model  	 = new UtilModel;
        $datetime_model  = new DateTimeModel;
        $user_model      = new UserModel;
        $post_model      = new PostModel;
        $postcategory_model = new PostcategoryModel;

        $data["user"]   = $this->_get_loggedin_user();
        $data["member"] = $user_model->get_user_by_id($member_id);

        if( $data["user"]->user_id === $data["member"]->user_id ){
            $data["if_user_view_own_profile"] = true;
       }else{
            $data["if_user_view_own_profile"] = false;
       }

       // Deck Section
       $arr_deck = $deck_model->get_by_user_id($data["user"]->user_id) ;
	   $data["arr_deck"] = [];
       foreach( $arr_deck as $deck ){

        $deck->course 			= $course_model->get_by_deck_id($deck->deck_id);
        array_push( $data["arr_deck"], $deck );

        $deck->num_all_card		=   count($card_model->get_by_deck_id($deck->deck_id));

        $arr_practice			= 	$practice_model->get_by_deck_id_user_id(
                                                    $deck->deck_id, 
                                                    $data["user"]->user_id);
        $deck->num_user_card  	=   count( $arr_practice );

        $deck->card_to_review_today   = count(  $practice_model->get_to_review(
                                                        $deck->deck_id, 
                                                        $data["user"]->user_id, 
                                                        time(), 
                                                        $next_day = 0 
                                                )
                                            );
        $deck->card_to_review_tomorrow   = count(  $practice_model->get_to_review(
                                                        $deck->deck_id, 
                                                        $data["user"]->user_id, 
                                                        time(), 
                                                        $next_day = 1 
                                                    )
                                                );
        $deck->average_card_interval =  $practice_model->get_average_interval(
                                                        $deck->deck_id,
                                                        $data["user"]->user_id
                                                );

        $deck->timespent 			 = 	$datetime_model->get_second_in_minute_and_hour(
                                                $statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                    $data["user"]->user_id,
                                                    $deck->deck_id
                                                )				
                                            );
        }       

        $data["arr_deck"] = $util_model->sort_array_of_object_by_the_property( 
                                                $objects = $arr_deck, 
                                                $sorted_property = "card_to_review_today" , 
                                                $order_by ="desc"
                                            );		
        $data["arr_deck"] = array_slice( $data["arr_deck"], 0, 3);

        // Post Section
        $arr_post = $post_model->get_by_user_id($data["member"]->user_id);
        $arr_post = $util_model->sort_array_of_object_by_the_property( 
                                $arr_post, 
                                "post_publisheddate", 
                                $order_by ="desc");
        $arr_post = array_slice($arr_post,0,3);

        $data["arr_post"] = [];
        foreach( $arr_post as $post){
            
            $post->user = $user_model->get_by_post_id( $post->post_id );
            $post->postcategory = $postcategory_model->get_by_post_id($post->post_id);
            $post->postcategory_num_card = $post_model->get_num_by_postcategory_id( $post->id_postcategory);
            $post->post_createddate = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                        $post->post_createddate );
            $post = $post_model->add_media_to_post($post);            

            array_push( $data["arr_post"], $post);
        }        

        
        // View Section
        if( $data["if_user_view_own_profile"] ){
            $data["page_title"] = 	"โปรไฟล์ของฉัน ";

        }else{
            $data["page_title"] = 	"โปรไฟล์ของ ".$data["member"]->displayname ;
            
        }

        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];	        
        $this->_view("member",$data);               
    }

    public function deck($member_id){

        $deck_model 	 = new DeckModel;
        $course_model 	 = new CourseModel;
        $card_model 	 = new CardModel;
        $practice_model  = new PracticeModel;
        $statistic_model = new StatisticModel;
        $datetime_model  = new DateTimeModel;
        $util_model  	 = new UtilModel;
        $user_model      = new UserModel;
        $post_model      = new PostModel;

        // User Management
        $data["user"]   = $this->_get_loggedin_user();
        $data["member"] = $user_model->get_user_by_id($member_id);

        if( $data["user"]->user_id === $data["member"]->user_id ){
            $data["if_user_view_own_profile"] = true;
        }else{
            $data["if_user_view_own_profile"] = false;
        }

        if( $data["if_user_view_own_profile"] === true){
            $arr_deck = $deck_model->get_by_user_id($data["user"]->user_id) ;
        }else{
            $arr_deck = $deck_model->get_by_user_id($data["member"]->user_id) ;
        }



        // Deck Section
        $data["arr_deck"] = [];
        foreach( $arr_deck as $deck ){
    
            $deck->course 			= $course_model->get_by_deck_id($deck->deck_id);
            array_push( $data["arr_deck"], $deck );
    
            $deck->num_all_card		=   count($card_model->get_by_deck_id($deck->deck_id));
    
            $arr_practice			= 	$practice_model->get_by_deck_id_user_id(
                                                        $deck->deck_id, 
                                                        $data["user"]->user_id);
            $deck->num_user_card  	=   count( $arr_practice );
    
            $deck->card_to_review_today   = count(  $practice_model->get_to_review(
                                                            $deck->deck_id, 
                                                            $data["user"]->user_id, 
                                                            time(), 
                                                            $next_day = 0 
                                                    )
                                                );
            $deck->card_to_review_tomorrow   = count(  $practice_model->get_to_review(
                                                            $deck->deck_id, 
                                                            $data["user"]->user_id, 
                                                            time(), 
                                                            $next_day = 1 
                                                        )
                                                    );
            $deck->average_card_interval =  $practice_model->get_average_interval(
                                                            $deck->deck_id,
                                                            $data["user"]->user_id
                                                    );
    
            $deck->timespent 			 = 	$datetime_model->get_second_in_minute_and_hour(
                                                    $statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                        $data["user"]->user_id,
                                                        $deck->deck_id
                                                    )				
                                                );
        }
    
        $data["arr_deck"] = $util_model->sort_array_of_object_by_the_property( 
                                                $objects = $arr_deck, 
                                                $sorted_property = "card_to_review_today" , 
                                                $order_by ="desc"
                                            );       

        // View Section
        
        if( $data["if_user_view_own_profile"] === true ){
            $data["page_title"] = 	"บัตรคำของฉัน";        
            $data["page_link"] 	= 	[	"โปรไฟล์ของฉัน ",
                                        base_url( ["Profile","member", $data["member"]->user_id] )
                                    ];

        }elseif( $data["if_user_view_own_profile"] === false ){
            $data["page_title"] = 	"บัตรคำของ ".$data["member"]->displayname;        
            $data["page_link"] 	= 	[	"โปรไฟล์ของ ".$data["member"]->displayname,
                                        base_url( ["Profile","member", $data["member"]->user_id] )
                                    ];
        }

        $this->_view("deck",$data);

    }

}

