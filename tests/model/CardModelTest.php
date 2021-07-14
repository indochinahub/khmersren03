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
    

    
}