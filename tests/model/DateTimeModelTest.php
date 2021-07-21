<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class DateTimeModelTest extends CIUnitTestCase
{
    var $datetime_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->datetime_model = new DateTimeModel();
    }

    // return Int
    public function test_get_unix_timestamp(){

        $result1 = $this->datetime_model->get_unix_timestamp(time(), $next_day = 0);
        $result2 = $this->datetime_model->get_unix_timestamp(time(), $next_day = 1);
        $result3 = $this->datetime_model->get_unix_timestamp(time(), $next_day = -1);
        $result4 = $this->datetime_model->get_unix_timestamp(time());

        $result             =   [ 
                                    $result1 > 0,
                                    ($result2 - $result1) === (60*60*24*1), 
                                    ($result1 - $result3) === (60*60*24*1), 
                                    $result4 > 0,
                                ];

        $expectedResult     =   [ 
                                    true,
                                    true,
                                    true,
                                    true,
                                ];

        $this->assertSame($result,$expectedResult);   

    }

    // return sql_timestamp
    public function test_unix_timestamp_to_sql_timestamp(){

        // unix_timestamp : 1626262031 :: "2021-07-14 18:27:11"
        $result1 = $this->datetime_model->unix_timestamp_to_sql_timestamp(1626262031);
        
        $result             =   [ 
                                    $result1,
                                ];

        $expectedResult     =   [ 
                                    "2021-07-14 18:27:11",
                                ];

        $this->assertSame($result,$expectedResult);   
    }

    // return date_part text
    function test_get_date_part_from_sql_timestamp(){

        $result1 = $this->datetime_model->get_date_part_from_sql_timestamp(
                                $sql_timestamp = "2021-01-24 14:15:01"
                                );

        $result             =   [ 
                                    $result1,
                                ];

        $expectedResult     =   [ 
                                    "2021-01-24",
                                ];

        $this->assertSame($result,$expectedResult);                   
    }


    // return unix_timestamp
    public function test_sql_timestamp_to_unix_timestamp(){

        // unix_timestamp : 1626262031 :: "2021-07-14 18:27:11"
        $result1 = $this->datetime_model->sql_timestamp_to_unix_timestamp(
                                $sql_timestamp = "2021-07-14 18:27:11"
                            );

        $result             =   [ 
                                    $result1,
                                ];

        $expectedResult     =   [ 
                                    1626262031,
                                ];

        $this->assertSame($result,$expectedResult);              
    }

    // return int
    public function test_get_unix_timestamp_at_midnight(){
        // unix_timestamp : 1626262031 :: "2021-07-14 18:27:11"
        $result1 = $this->datetime_model->get_unix_timestamp_at_midnight(
                                    $unix_timestamp = 1626262031
                                );

        $result2 = $this->datetime_model->get_unix_timestamp_at_midnight(
                                    $unix_timestamp = 1626262031,
                                    $next_day = 5
                                );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];

        $expectedResult     =   [ 
                                    1626195600, //  2021-07-14 00:00:00
                                    1626627600, //  2021-07-19 00:00:00
                                ];

        $this->assertSame($result,$expectedResult);           
    }

    // return int
    function test_get_iterval_num_day(){

        $result1 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 1, 
                                $interval_constant= 4
                            );
        $result2 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 2, 
                                $interval_constant= 4
                            );
        $result3 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 3, 
                                $interval_constant= 4
                            );
        $result4 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 10, 
                                $interval_constant= 4
                            );
        $result5 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 2000, 
                                $interval_constant= 4
                            );
        $result6 = $this->datetime_model->get_iterval_num_day( 
                                $current_interval = 5000, 
                                $interval_constant= 4
                            );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                    $result3,
                                    $result4,
                                    $result5,
                                    $result6,
                                ];
        $expectedResult     =   [ 
                                    2,
                                    8,
                                    12,
                                    40,
                                    8000,
                                    10000,
                                ];

        $this->assertSame($result,$expectedResult);
    }


    // return text
    function test_get_thai_date_from_sql_timestamp(){

        $result1 = $this->datetime_model->get_thai_date_from_sql_timestamp(
                                $sql_timestamp = "2021-01-28 09:39:42"
                            );
    
        $result         =   [   
                                $result1
                            ];

        $expectedResult =   [
                                "28 ม.ค. 2564"
                            ];
        $this->assertSame($expectedResult, $result);
    }

    
}