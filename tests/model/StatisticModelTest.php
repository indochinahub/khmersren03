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

    // return array of text
    public function test_get_last_midnight(){

        //1628670923 :: 2021-08-11 15:35:23        
        $result1 = $this->statistic_model->get_last_midnight( 1628670923 , $num_day = 15);

        $result         =   [ 
                                count($result1),
                                $result1[0],
                                $result1[14],
                            ];
        $expectedResult =   [ 
                                15,
                                "2021-08-11 00:00:00",
                                "2021-07-28 00:00:00",
                            ];

        $this->assertSame($expectedResult, $result);                
    }

    
}