<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class CardcommentModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->cardcomment_model = new CardcommentModel();

    }
    
    // return array of object
    public function test_get_by_deck_id(){

        $result1 = $this->cardcomment_model->get_by_deck_id($deck_id = 1);
        $result2 = $this->cardcomment_model->get_by_deck_id($deck_id = 0);

        $result         =   [ 
                                count($result1),
                                count($result2),
                            ];
        $expectedResult =   [ 
                                6,
                                0,
                            ];

        $this->assertSame($expectedResult, $result);   
    }
    
    // return array of object
    public function test_get_by_card_id_and_deck_id(){

        $result1 = $this->cardcomment_model->get_by_card_id_and_deck_id(
                                $card_id = 1, 
                                $deck_id = 1
                            );
        $result2 = $this->cardcomment_model->get_by_card_id_and_deck_id(
                                $card_id = 0, 
                                $deck_id = 0
                            );


        $result         =   [ 
                                count($result1),
                                count($result2),
                            ];
        $expectedResult =   [ 
                                6,
                                0,
                            ];

        $this->assertSame($expectedResult, $result);        
    }

    
}