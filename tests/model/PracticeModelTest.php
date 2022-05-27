<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PracticeModel;

class PracticeModelTest extends CIUnitTestCase
{
    var $practice_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->practice_model = new PracticeModel();

        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  id_user = 1 ";
        $query = $this->practice_model->query($sql);        

    }
    
    //return array of ojbect or blank array
    public function test_get_by_deck_id_user_id(){
        
        $result1 = $this->practice_model->get_by_deck_id_user_id($deck_id = 1, $user_id = 1);
        $result2 = $this->practice_model->get_by_deck_id_user_id($deck_id = 0, $user_id = 1);

        $result         =   [ 
                                count($result1),
                                $result2,
                            ];

        $expectedResult =   [ 
                                12,
                                []
                            ];

        $this->assertSame($expectedResult, $result);    

    }

    // return array of object
    public function test_get_to_review(){
        $result1 =  $this->practice_model->get_to_review(
                                    $deck_id = 1, 
                                    $user_id = 1, 
                                    $unix_timestamp = 1582567200, // sqlTimeStamp = '2020-02-25 01:00:00'
                                    $next_day = 0
                                );

        $result2 =  $this->practice_model->get_to_review(
                                    $user_id = 1,
                                    $deck_id = 1,
                                    $unix_timestamp = time(), // now
                                    $next_day= 0    
                                );
                                
        $result3 =  $this->practice_model->get_to_review(
                                    $user_id = 0,
                                    $deck_id = 0,
                                    $unix_timestamp = time(),
                                    $next_day= 0    
                                );


        $result         =   [ 
                                count($result1),
                                count($result2),
                                count($result3),
                            ];

        $expectedResult =   [ 
                                9, 
                                12,
                                0,
                            ];

        $this->assertSame($expectedResult, $result);    
    }

    // return object or false
    public function test_get_by_card_id_deck_id_user_id(){    

        $result1 = $this->practice_model->get_by_card_id_deck_id_user_id(
                                                $card_id = 1, 
                                                $deck_id = 1, 
                                                $user_id = 1
                                            );

        $result2 = $this->practice_model->get_by_card_id_deck_id_user_id(
                                                $card_id = 0, 
                                                $deck_id = 0, 
                                                $user_id = 0
                                            );

        $result         =   [ 
                                $result1->practice_id,
                                $result2
                            ];
        $expectedResult =   [ 
                                "1",
                                false
                            ];

        $this->assertSame($expectedResult, $result);

    }

    // return object or false
    public function test_get_last_by_user_id(){

        // Today :: 2021-03-24
        // unixtime 1616582552 :: 2021-03-24 17:42:32

        $result1 =  $this->practice_model->get_last_by_user_id($user_id = 2 );
        $result2 =  $this->practice_model->get_last_by_user_id($user_id = 0 );

        $result         =   [ 
                                $result1->practice_id,
                                is_object($result1),
                                $result2,
                            ];
        $expectedResult =   [ 
                                "29727",
                                true,
                                false,
                            ];

        $this->assertSame($expectedResult, $result);
    }

    // return Int Or Zero
    public function test_get_average_interval(){
        

        $result1 = $this->practice_model->get_average_interval(
                                    $deck_id = 0,
                                    $user_id = 0
                                );

        $result2 = $this->practice_model->get_average_interval(
                                    $deck_id = 1,
                                    $user_id = 1
                                );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    0,
                                    1,
                                ];

        $this->assertSame($result,$expectedResult);        
    }

    // return int or zero
    public function test_get_sum_visit_time(){

        $result1 = $this->practice_model->get_sum_visit_time(
                                        $deck_id = 0, 
                                        $user_id = 0
                                    );
        
        $result2 = $this->practice_model->get_sum_visit_time(
                                        $deck_id = 1, 
                                        $user_id = 1
                                    );
                            

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];

        $expectedResult     =   [ 
                                    0,
                                    14,
                                ];

        $this->assertSame($result,$expectedResult);                

    }

    // return int or zero
    public function test_get_num_practice_have_done_of_the_day(){

        // The day '2021-02-20 10:10:10' :: 1613790610
        $result1 = $this->practice_model->get_num_practice_have_done_of_the_day($user_id = 0, $unix_timestamp = 1613790610 );
        $result2 = $this->practice_model->get_num_practice_have_done_of_the_day($user_id = 1, $unix_timestamp = 1613790610 );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    0,
                                    4,
                                ];

        $this->assertSame($result,$expectedResult);                
    }

    // return int
    public function test_get_timespent_of_the_day(){

        $sql =  " UPDATE practice SET practice_timespent = 10 ";
        $sql .= " WHERE  practice_id = 158 OR ";
        $sql .= " practice_id = 159 OR "; 
        $sql .= " practice_id = 28496 OR "; 
        $sql .= " practice_id = 28497 ";
        $this->practice_model->query($sql);

        // The day '2021-02-20 10:10:10' :: 1613790610
        $result1 = $this->practice_model->get_timespent_of_the_day($user_id = 0 , $unix_timestamp = 1613790610);
        $result2 = $this->practice_model->get_timespent_of_the_day($user_id = 1 , $unix_timestamp = 1613790610);

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    0,
                                    40,
                                ];
        $this->assertSame($result,$expectedResult);                
    }    

    // return int
    public function test_get_total_num_to_review(){

        // unix_timestamp = 1582567200
        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result1 = $this->practice_model->get_total_num_to_review( 
                            $user_id = 1, 
                            $unix_timestamp = 1582567200, 
                            $next_day = 1
                        );
        

        $result2 = $this->practice_model->get_total_num_to_review( 
                            $user_id = 0, 
                            $unix_timestamp = time(), 
                            $next_day = 1
                        );
                        
        $result             =   [ 
                                    $result1, 
                                    $result2, 
                                ];
        $expectedResult     =   [ 
                                    12,
                                    0,
                                ];
        $this->assertSame($result,$expectedResult);                        
    }
    
}