<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\CardModel;

class CardModelTest extends CIUnitTestCase
{
    var $card_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->card_model = new CardModel();
    }

    // return array of card or blank array
    public function test_get_by_cardgroup_id(){

        $result1 = $this->card_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result2 = $this->card_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result             =   [ 
                                    count($result1),
                                    $result2
                                ];
        $expectedResult     =   [ 
                                    15,
                                    [],
                                ];

        $this->assertSame($result,$expectedResult);                
    }

    // return array Of object Or blank array
    public function test_get_by_deck_id(){
        $card_model = new CardModel();
        
        $result1 = $card_model->get_by_deck_id($deck_id = 1 );
        $result2 = $card_model->get_by_deck_id($deck_id = 0 );

        $result             =   [ 
                                    count($result1),
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    15,
                                    [],
                                ];

        $this->assertSame($result,$expectedResult);        

    }

    // return id int
    public function test_get_next_card_id_to_review(){

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result1 = $this->card_model->get_next_card_id_to_review(
                                    $deck_id = 1, 
                                    $user_id = 1, 
                                    $unix_timestamp= 1582567200
                                );

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result2 = $this->card_model->get_next_card_id_to_review(
                                    $deck_id = 0, 
                                    $user_id = 1, 
                                    $unix_timestamp= 1582567200
                                );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    3,
                                    false,
                                ];
        $this->assertSame($result,$expectedResult);    

    }

    // return id int
    public function get_new_card_id_to_learn(){

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $this->card_model->get_new_card_id_to_learn(
                            $deck_id = 1, 
                            $user_id = 1, 
                            $unix_timestamp = 1582567200
                        );

        $result             =   [ 
                                    0,
                                ];

        $expectedResult     =   [ 
                                    1,
                                ];

        $this->assertSame($result,$expectedResult);    

        /*
        

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result01 =  $this->card_model->get_new_card_id_to_learn($user_id = 1, $deck_id = 1, $unix_timestamp = 1582567200);

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result02 =  $this->card_model->get_new_card_id_to_learn($user_id = 0, $deck_id = 0, $unix_timestamp = 1582567200);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   13,
                                FALSE
                            ];


        */

    }

    
}