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
        $sql .=  " WHERE  id_user = 1 ";
        $query = $this->statistic_model->query($sql);        

        $sql  =     " DELETE FROM statistic WHERE  id_user = 1 ";
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
        $sql .=  " WHERE  id_user = 1 ";
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

       // a. Add sample data
        $sql  =  " UPDATE practice SET practice_timespent = 2 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);

        $result1 = $this->statistic_model->create_daily_statistic($user_id = 0, time());
        $result2 = $this->statistic_model->create_daily_statistic($user_id = 1, time());

        // a. Delete sample data
        $sql  =  " UPDATE practice SET practice_timespent = 0 ";
        $sql .=  " WHERE  practice_id in (1,2,4,5) ";
        $query = $this->statistic_model->query($sql);
        
        // a. Delete Statistic Data
        $sql  =  " DELETE FROM statistic WHERE  id_user = 1 ";
        $query = $this->statistic_model->query($sql);

        // b. Addd Sample Statistic Data
        $sql  =     " INSERT INTO statistic(id_user, id_deck, statistic_timespent, statistic_numcard, statistic_datetime) ";
        $sql  .=    " VALUES (1, 1, 2, 3, '2021-08-13 00:00:00' ) ";
        $query = $this->statistic_model->query($sql);

        //unix_timestamp = 1628824012 ::  "2021-08-13 10:06:52"
        // No need to create statistic
        $result3 = $this->statistic_model->create_daily_statistic($user_id = 1, 1628824012 );

        // b. Delete sample data
        $sql  =     " DELETE FROM statistic WHERE  id_user = 1 ";
        $query = $this->statistic_model->query($sql);  
        
        $result         =   [   
                                $result1,
                                count($result2),
                                $result3,

                            ];
        $expectedResult =   [   
                                [],
                                2,
                                [],
                            ];
        $this->assertSame($expectedResult, $result);                
    }

    // return true or false
    public function test_if_there_is_today_statistic(){

        $datetime_model = new DatetimeModel;

        // Create sample data
        $sql  =     " INSERT INTO statistic(id_user, id_deck, statistic_timespent, statistic_numcard, statistic_datetime) ";
        $sql  .=    " VALUES (1, 1, 2, 3, '2021-08-13 00:00:00' ) ";
        $query = $this->statistic_model->query($sql);


        $unix_timestamp = 1628824012; //  "2021-08-13 10:06:52"

        $result1 = $this->statistic_model->if_there_is_today_statistic(
                                            $user_id = 1, 
                                            $unix_timestamp
                                    );

        // There is no statistic for user_id = 0
        $result2 = $this->statistic_model->if_there_is_today_statistic(
                                            $user_id = 0, 
                                            $unix_timestamp
                                    );                                    
        $result         =   [   
                                $result1, 
                                $result2,
                            ];
        $expectedResult =   [   
                                true,
                                false
                            ];
        $this->assertSame($expectedResult, $result);        

        // Delete sample data
        $sql  =     " DELETE FROM statistic WHERE  id_user = 1 ";
        $query = $this->statistic_model->query($sql);        
    }
    
    // return array of statistic
    public function test_get_daily_statistic(){

        $result1 = $this->statistic_model->get_daily_statistic($user_id = 0);
        $result2 = $this->statistic_model->get_daily_statistic($user_id = 6);

        $result         =   [   
                                $result1,
                                count($result2) > 0,

                            ];
        $expectedResult =   [   
                                [],
                                true,
                            ];
        $this->assertSame($expectedResult, $result);        
    }

    //return int or false
    public function test_get_num_day_from_start(){

        $result1 = $this->statistic_model->get_num_day_from_start($user_id = 0);
        $result2 = $this->statistic_model->get_num_day_from_start($user_id = 6);

        $result         =   [   
                                $result1,
                                $result2 > 0,
                            ];
        $expectedResult =   [   
                                0,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);
    }    

    // return int or zero
    public function test_get_total_timespent_of_user(){

        $result1 = $this->statistic_model->get_total_timespent_of_user($user_id = 0);
        $result2 = $this->statistic_model->get_total_timespent_of_user($user_id = 6);

        $result         =   [   
                                $result1, 
                                $result2 > 15000
                            ];
        $expectedResult =   [   
                                0,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);        
    }
    
    //return arr of statistic
    public function test_get_last_15_day_statistic(){

        $unix_timestamp = 1628824012; //  "2021-08-13 10:06:52"

        $result1 = $this->statistic_model->get_last_15_day_statistic($user_id = 0, $unix_timestamp );
        $result2 = $this->statistic_model->get_last_15_day_statistic($user_id = 6, $unix_timestamp );

        $result         =   [
                                // result1[0]
                                $result1[0]->date,
                                $result1[0]->timespent,
                                $result1[0]->num_card,

                                // result2[0]
                                $result2[0]->date,
                                $result2[0]->timespent,
                                $result2[0]->num_card,

                                // result2[1]
                                $result2[1]->date,
                                $result2[1]->timespent,
                                $result2[1]->num_card,
                            ];

        $expectedResult =   [   
                                "2021-08-13 00:00:00",
                                0,
                                0,

                                "2021-08-13 00:00:00",
                                0,
                                0,

                                "2021-08-12 00:00:00",
                                0,
                                0,
                            ];
        $this->assertSame($expectedResult, $result);        
    }    

}