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
use App\Models\DatetimeModel;
use App\Models\StatisticModel;
use App\Models\PostModel;

class Deck extends MyController
{

    public function show($deck_id){

        $deck_model     = new DeckModel;
        $card_model     = new CardModel;
        $practice_model = new PracticeModel;
        $util_model     = new UtilModel;
        $course_model   = new CourseModel;
        $user_model     = new UserModel;


        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"] = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);

        $data["next_card_id"] = $card_model->get_next_card_id(
                                                $deck_id, 
                                                $data["user"]->user_id, 
                                                time());

        // Statistic Section
        $data["num_all_card"] = count($card_model->get_by_deck_id($deck_id));

        $arr_practice = $practice_model->get_by_deck_id_user_id(
                            $deck_id, 
                            $data["user"]->user_id);

        $data["num_user_card"] = count( $arr_practice );
        $data["card_to_review_today"] = count(    $practice_model->get_to_review(
                                    $deck_id, 
                                    $data["user"]->user_id, 
                                    time(), 
                                    $next_day = 0 )
                            );
        $data["card_to_review_tomorrow"] = count(    $practice_model->get_to_review(
                                    $deck_id, 
                                    $data["user"]->user_id, 
                                    time(), 
                                    $next_day = 1)
                                );  
        $data["avarage_card_interval"] = $practice_model->get_average_interval(
                                            $deck_id,
                                            $data["user"]->user_id
                                        );
        $data["sum_visit_time"] = $practice_model->get_sum_visit_time(
                                        $deck_id, 
                                        $data["user"]->user_id
                                    );
        
        // Display User Visited
        $arr_visited_user = $user_model->get_last_visit_user_of_deck($deck_id, $num = 8);

        $data["arr_user_to_show"] = [];
        foreach( $arr_visited_user as $user ){

            $user->displayname = $user_model->get_user_displayname($user);
            $user->avarta_url = $user_model->get_avarta_url($user);
            array_push( $data["arr_user_to_show"], $user);
        }

        $data["arr_user_to_show"] = $util_model->sort_array_of_object_by_the_property( 
                                            $data["arr_user_to_show"], 
                                            "user_visittime", 
                                            $order_by ="desc"
                                        );
        $data["arr_user_to_show"] = $util_model->saparate_array_to_row(
                                            $data["arr_user_to_show"],
                                            2,
                                            4
                                        );

        // View Section
        $data["page_title"] = 	"ชุตบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name; 
        $data["page_link"] 	= 	[	"วิชา ".$data["course"]->course_code,
                                    base_url( ["Course","show", $data["course"]->course_id] )
                               ];	        
        $this->_view("show",$data);        
    }

    public function showAllCard($deck_id){

        $card_model     = new CardModel;
        $deck_model     = new DeckModel;
        $course_model   = new CourseModel;
        $pagination_model = new PaginationModel;

        $pager = service('pager');

        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"] = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);
        $arr_card = $card_model->get_by_deck_id($deck_id);


		if( ! ($page = $this->request->getGet('page')) ){
			$page = 1;
		}
		$pagination = $pagination_model->get_pagination( 
                                        $arr_card, 
                                        $current_page = $page , 
                                        $per_page = 20
                                    );
		$data["pagination_link"] = $pagination->link;
        $arr_card = $pagination->arr_row;        

        $data["arr_card"] = [];
        foreach( $arr_card as $card){

            $card->arr_command = $card_model->get_card_command(
                                                    $card, 
                                                    $data["course"], 
                                                    $data["deck"]
                                                );

            $card->arr_choice   = $card_model->get_card_choice(
                                                    $card, 
                                                    $data["course"], 
                                                    $data["deck"],
                                                    [0,1,2,3]
                                                );

            $card->arr_answer   = $card_model->get_card_answer(
                                                    $card, 
                                                    $data["course"], 
                                                    $data["deck"]
                                                );                                                

            array_push($data["arr_card"], $card);
        }

        $data["page_title"] = 	"บัตรคำทั้งหมดในชุด ".$data["course"]->course_code."-".$data["deck"]->deck_name; 
        $data["page_link"] 	= 	[   "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name,
                                    base_url(["Deck","show", $deck_id])
                               ];
                               
        $this->_view("showAllCard",$data);        
    }

    public function showAllComment($deck_id){

        $cardcomment_model  = new CardcommentModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $deck_model         = new DeckModel;
        $course_model       = new CourseModel;
        $card_model         = new CardModel;
        $user_model         = new UserModel;
        $datetime_model     = new DatetimeModel;

        $assoc_deck         =  $deck_model->get_all_rows_as_assoc();
        $assoc_user         =  $user_model->get_all_rows_as_assoc();
        $data["course"]     = $course_model->get_by_deck_id($deck_id);
        $data["deck"]       = $deck_model->get_by_id($deck_id);

        $arr_cardcomment = $cardcomment_model->get_by_deck_id($deck_id);
        

        $arr_cardcomment = $util_model->sort_array_of_object_by_the_property( 
            $arr_cardcomment, 
            "cardcomment_id", 
            $order_by ="desc"
        );

        if( ! ($page = $this->request->getGet('page')) ){
        $page = 1;
        }

        $pagination = $pagination_model->get_pagination( 
                        $arr_cardcomment, 
                        $current_page = $page , 
                        $per_page = 20
                    );
        $data["pagination_link"] = $pagination->link;
        $arr_cardcomment = $pagination->arr_row;
        
        $data["arr_cardcomment"] = [];
        foreach( $arr_cardcomment as $cardcomment){

            $cardcomment->card                  = $card_model->get_by_id($cardcomment->id_card);
            $cardcomment->user                  = $assoc_user[$cardcomment->id_user];
            $cardcomment->user->display_name    = $this->user_model->get_user_displayname($cardcomment->user);
            $cardcomment->visited_time          = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                                            $cardcomment->cardcomment_createtime
                                                        );
            array_push($data["arr_cardcomment"], $cardcomment);
        }        

        $data["page_title"] = 	"ความเห็นสำหรับชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name;
        $data["page_link"] 	= 	[   "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name,
                                    base_url(["Deck","show",$data["deck"]->deck_id])
                                    
                               ];
                               
        $this->_view("showAllComment",$data);                
    }

    public function clearAllCard($deck_id, $confirm = "0"){

        $deck_model     = new DeckModel;
        $course_model   = new CourseModel;
        $practice_model = new PracticeModel;
        $util_model     = new UtilModel;

        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }        

        $deck = $deck_model->get_by_id($deck_id);
        $course = $course_model->get_by_deck_id($deck_id);

        if( $confirm === "0"){

            $data    =  [   "page_title"=>"ยืนยันการล้างบัตรคำ",
                            "what_happened"=>"คุณกำลังล้างบัตรคำในชุดบัตรคำ <strong>".$course->course_code."-".$deck->deck_name."</strong> จำนวน ". "ข้อ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Deck","clearAllCard",$deck_id, 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Deck","show",$deck_id]),
                        ];  		

            $this->_confirm($data);            

        }elseif(  $confirm === "1" ){
            $arr_practice = $practice_model->get_by_deck_id_user_id(
                                                    $deck_id, 
                                                    $user->user_id
                                                );
            $arr_practice_id = $util_model->get_property_value_Of_many_objects_as_array(
                                                    $arr_practice,
                                                    "practice_id"
                                                );
            $practice_model->delete_by_ids( $arr_practice_id );

            return redirect()->to(base_url( ["Deck","show",$deck_id] ));		
        }

    }

    public function myDeck($member_id){

        $deck_model 	 = new DeckModel;
        $course_model 	 = new CourseModel;
        $card_model 	 = new CardModel;
        $practice_model  = new PracticeModel;
        $statistic_model = new StatisticModel;
        $datetime_model  = new DatetimeModel;
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


        $arr_deck = $deck_model->get_by_user_id($data["member"]->user_id) ;

        // Deck Section
        $data["arr_deck"] = [];
        foreach( $arr_deck as $deck ){
    
            $deck->course 			= $course_model->get_by_deck_id($deck->deck_id);
            array_push( $data["arr_deck"], $deck );
    
            $deck->num_all_card		=   count($card_model->get_by_deck_id($deck->deck_id));
    
            $arr_practice			= 	$practice_model->get_by_deck_id_user_id(
                                                        $deck->deck_id, 
                                                        $data["member"]->user_id);
            $deck->num_user_card  	=   count( $arr_practice );
    
            $deck->card_to_review_today   = count(  $practice_model->get_to_review(
                                                            $deck->deck_id, 
                                                            $data["member"]->user_id, 
                                                            time(), 
                                                            $next_day = 0 
                                                    )
                                                );
            $deck->card_to_review_tomorrow   = count(  $practice_model->get_to_review(
                                                            $deck->deck_id, 
                                                            $data["member"]->user_id, 
                                                            time(), 
                                                            $next_day = 1 
                                                        )
                                                    );
            $deck->average_card_interval =  $practice_model->get_average_interval(
                                                            $deck->deck_id,
                                                            $data["member"]->user_id
                                                    );
    
            $deck->timespent 			 = 	$datetime_model->get_second_in_minute_and_hour(
                                                    $statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                        $data["member"]->user_id,
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
                                        base_url( ["User","myProfile", $data["user"]->user_id] )
                                    ];

        }elseif( $data["if_user_view_own_profile"] === false ){
            $data["page_title"] = 	"บัตรคำของ ".$data["member"]->displayname;        
            $data["page_link"] 	= 	[	"โปรไฟล์ของ ".$data["member"]->displayname,
                                        base_url( ["User","myProfile", $data["member"]->user_id] )
                                    ];
        }

        $this->_view("myDeck",$data);

    }

    public function manage(){

        if( ($data["user"] = $this->_get_loggedin_user())
        && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $data["page_title"] = 	"จัดการบัตรคำ";        
        $data["page_link"] 	= 	[	"กลับ ",
                                    $this->_get_backlink()
                                ];
        $this->_view("manage",$data);


    }


}

