<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class StatisticModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->statistic_model = new StatisticModel();

        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);



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

    // return num_rows
    public function test_reset_practice_timespent(){

        $sql  =  " UPDATE practice SET practice_timespent = 1 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);

        $result1 = $this->statistic_model->reset_practice_timespent($user_id = 1);
        $result2 = $this->statistic_model->reset_practice_timespent($user_id = 0);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                4,
                                0,
                            ];
        $this->assertSame($expectedResult, $result);        

        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);        
    }

    //return array of statistic
    public function test_get_now_statistic(){

        // Add sample data
        $sql  =  " UPDATE practice SET practice_timespent = 2 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);        

        $result1 = $this->statistic_model->get_now_statistic($user_id = 0);
        $result2 = $this->statistic_model->get_now_statistic($user_id = 1);

        $result         =   [   // result1
                                $result1,
                                
                                // result2
                                $result2[0]->id_deck,
                                $result2[0]->num_card,
                                $result2[0]->timespent,

                                $result2[1]->id_deck,
                                $result2[1]->num_card,
                                $result2[1]->timespent,                               
                            ];
        $expectedResult =   [   // result1
                                [],

                                // result12
                                "1",
                                "2",
                                "4",

                                "2",
                                "2",
                                "4",
                            ];
        $this->assertSame($expectedResult, $result);                

        // Delete sample data
        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);                
    }    

    // return array of key id
    public function test_create_daily_statistic(){

       // Add sample data
        $sql  =  " UPDATE practice SET practice_timespent = 2 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);

        $result1 = $this->statistic_model->create_daily_statistic($user_id = 0);
        $result2 = $this->statistic_model->create_daily_statistic($user_id = 1);

        $result         =   [   
                                $result1,
                                count($result2),

                            ];
        $expectedResult =   [   
                                [],
                                2,
                            ];
        $this->assertSame($expectedResult, $result);                

        // Delete sample data
        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);
        
        // Delete Statistic Data
        $sql  =  " DELETE FROM statistic WHERE  id_user = 1 ";
        $query = $this->statistic_model->query($sql);
    }



}