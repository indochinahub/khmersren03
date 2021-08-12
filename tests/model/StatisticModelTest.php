<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class StatisticModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->statistic_model = new StatisticModel();

    }    

    // return int
    public function test_get_sum_spenttime_by_user_id_and_deck_id(){

        $result1 = $this->statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                $user_id = 3,
                                                $deck_id = 18
                                            );
        $result2 = $this->statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                $user_id = 2,
                                                $deck_id = 18
                                            );
        $result3 = $this->statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                                                $user_id = 0,
                                                $deck_id = 0
                                            );
    
        $result         =   [ 
                                $result1,
                                $result2,
                                $result3,
                            ];

        $expectedResult =   [ 
                                44,
                                0,
                                0,
                            ];

        $this->assertSame($expectedResult, $result);        

    }


}