<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DateTimeModel;
use \App\Models\UtilModel;
use \App\Models\PostModel;
use \App\Models\PostcategoryModel;

class User extends MyController
{
	public function login()	{
		
		$user_model = new UserModel();

		$validattion_rules = 	[	'username' => 'required',
									'password' => 'required'
								];

		// Set the task
		$data = [];
		if( ($this->request->getMethod() === "post") && ($this->validate($validattion_rules)) ){
			$data["task"] = "validate_user";
			
		}elseif( $this->request->getMethod() === "post" ){
			$data["username_error"] = $this->validator->getError('username');
			$data["password_error"] = $this->validator->getError('password');
			$data["task"] = "form_error";

		}else{
			$data["task"] = "form_blank";

		}

		// Do the task
		if($data["task"] === "form_blank"){

			// Clear session
			$this->session->remove('uid');
			if( isset($_COOKIE["uid"])){
				setcookie('uid', $_COOKIE["uid"], time() - (86400 * 7), "/");
			}			

			$data["username"]  = "";

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);			

		}elseif($data["task"] === "form_error"){

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);		

		}elseif($data["task"] === "validate_user"){
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			if( $user = $user_model->get_validated_user($username, $password)){

				$this->session->set('uid', $user->user_id);

				return redirect()->to(base_url());

			}else{
								
				$data	= [     "page_title"=>"รหัสผ่านไม่ถูกต้อง",
								"what_happened"=>"ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
								"what_todo" => "กรุณาตรวจสอบชื่อผู้ใช้และรหัสผ่านใหม่และเข้าสู่ระบบอีกครั้ง",
								"btnText_toGo" => "Back",
								"btnLink_toGo" => base_url(["User", "login"])
						];
				$this->_warn($data);
			}
			
		}
	}

	public function logout(){

		$this->session->remove('uid');
		if( isset($_COOKIE["uid"])){
            setcookie('uid', $_COOKIE["uid"], time() - (86400 * 7), "/");
        }
		return redirect()->to(base_url(["User","login"]));		

	}

    public function myProfile($member_id){
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
        
        // Postcategory Section
        if( $default_postcategory = $postcategory_model->get_default_postcategory($data["member"]->user_id)){ 
        }else{
            $default_postcategory_id = $postcategory_model->insert_default_postcategory($data["member"]->user_id);
            $default_postcategory = $postcategory_model->get_by_id( $default_postcategory_id );
        }

        $arr_user_postcategory =   $postcategory_model->get_user_postcategory($data["member"]->user_id);

        $arr_postcategory = array_merge([ $default_postcategory ],$arr_user_postcategory );

        $data["arr_postcategory"] = [];
        foreach( $arr_postcategory as $postcategory ){
            $postcategory->num_post = $post_model->get_num_by_postcategory_id($postcategory->postcategory_id);
            array_push( $data["arr_postcategory"] , $postcategory );
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
        $this->_view("profile",$data);               
    }


}

