<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\DateTimeModel;

class Card extends MyController
{
    public function show($page, $card_id, $deck_id){

        $deck_model = new DeckModel;
        $course_model = new CourseModel;
        $card_model = new CardModel;
        $practice_model = new PracticeModel;
        $datetime_model = new DateTimeModel;

        // Get Login User
        if( $data["user"] = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        $data["deck"]   = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);
        $data["card"]   = $card_model->get_by_id($card_id);
        $data["page"] = $page;
        $practice = $practice_model->get_by_card_id_deck_id_user_id(
                                $card_id, 
                                $deck_id, 
                                $data["user"]->user_id
                            );

        // Command Section
        $data["arr_command"] = $card_model->get_card_command(
                                            $data["card"], 
                                            $data["course"], 
                                            $data["deck"]
                                        );
        
        if( $data["page"] === "a"){
            $data["key_of_choices"] = [ 0, 1, 2, 3];
            shuffle( $data["key_of_choices"] );

        }elseif( $data["page"] === "b"){
            $arr_segment = $this->uri->getSegments();
            $data["key_of_choices"] =   [      
                                            (int)$arr_segment[5],
                                            (int)$arr_segment[6],
                                            (int)$arr_segment[7],
                                            (int)$arr_segment[8],
                                        ];
            $data["selected_choice"] =  (int) $arr_segment[9] ;
        }

        // Choice Section
        $data["arr_choice"] = $card_model->get_card_choice(
                                        $data["card"], 
                                        $data["course"], 
                                        $data["deck"],
                                        $data["key_of_choices"]
                                    );


        // Some Value abou time
        $next_midnight_unix_timestamp =  $datetime_model->get_unix_timestamp_at_midnight( 
                    $datetime_model->get_unix_timestamp( time(), $next_day = 1)
                );

        $next_midnight_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
                    $next_midnight_unix_timestamp
                ); 

        $now_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(time());
        
        $today_date = $datetime_model->get_date_part_from_sql_timestamp($now_sql_timestamp);

        $last_visit_date = $datetime_model->get_date_part_from_sql_timestamp(
                                                $practice->practice_lastVisitDate
                                            );                    
        

        
        // If there is no practice, add the practice
        if( ($data["page"] === "b") && ($practice === false) ){

            $detail =   [       "id_deck"=>$deck_id,
                                "id_card"=>$card_id,
                                "id_user"=>$data["user"]->user_id,
                                "practice_nextVisitDate"=>$next_midnight_sql_timestamp
                        ];
            $practice_id = $practice_model->insert($detail);

            $practice = $practice_model->get_by_id($practice_id);;

        // If there is existing Practice, get time, 
        }elseif( $data["page"] === "b"){



        }


        // New card or the card which is redone in the same day
        if( ($data["page"] === "b") && ($today_date === $last_visit_date) ){
            $detail =   [       
                            "practice_lastVisitDate"=>$now_sql_timestamp
                        ];

        // Select the right answer
        }elseif(  ($data["page"] === "b") && $data["selected_choice"] === 0){
            
            $iterval_num_day = $datetime_model->get_iterval_num_day( 
                                        $practice->practice_intervalDay, 
                                        $data["deck"]->deck_intervalconstant
                                    );
            $next_visit_date = $datetime_model->unix_timestamp_to_sql_timestamp(
                                        $datetime_model->get_unix_timestamp_at_midnight( 
                                                time() , 
                                                $iterval_num_day
                                        )
                                );
            
            $detail = [   
                "practice_intervalDay"=>$iterval_num_day,
                "practice_lastVisitDate"=>$now_sql_timestamp ,
                "practice_nextVisitDate"=>$next_visit_date ,
                "practice_counter"=> $practice->practice_counter + 1,
                "practice_timespent"=>0,
            ];            

        // Select the wrong answer 
        }elseif( ($data["page"] === "b") && $data["selected_choice"] !== 0 ){

            $iterval_num_day = 2;
            $next_visit_date = $datetime_model->unix_timestamp_to_sql_timestamp(
                                        $datetime_model->get_unix_timestamp_at_midnight( 
                                            time() , 
                                            1
                                        )
                                    );

            $detail = [   
                "practice_intervalDay"=>$iterval_num_day = $iterval_num_day,
                "practice_lastVisitDate"=>$now_sql_timestamp,
                "practice_nextVisitDate"=>$next_visit_date,
                "practice_counter"=> $practice->practice_counter + 1,
                "practice_timespent"=>0,
                
            ];              

        }

        // Update
        if( $data["page"] === "b" ){
            $practice_model->update_by_id(  $practice->practice_id,
                                            $detail
                                        );
        }






        

                // Result Section
        $data["next_card_id"] = $card_model->get_next_card_id(
                                        $data["deck"]->deck_id, 
                                        $data["user"]->user_id, 
                                        time()
                                    );  

        







        // View Section
        $data["page_title"] = 	"xxxxx";
        $data["page_link"] 	= 	[ "Deck", "#"];	        
        $this->_view("show",$data);        

    }


}

