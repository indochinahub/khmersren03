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

    
}