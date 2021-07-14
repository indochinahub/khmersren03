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

    
}