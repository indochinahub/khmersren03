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

        $result1 = $this->datetime_model->get_unix_timestamp($next_day = 0);
        $result2 = $this->datetime_model->get_unix_timestamp($next_day = 1);
        $result3 = $this->datetime_model->get_unix_timestamp($next_day = -1);
        $result4 = $this->datetime_model->get_unix_timestamp();

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






    // return int
    public function get_unix_timestamp_at_midnight(){
        // unix_timestamp : 1626262031 :: "2021-07-14 18:27:11"
        $result1 = $this->datetime_model->get_unix_timestamp_at_midnight(
                                    $unix_timestamp = 1626262031
                                );
        
        $result             =   [ 
                                    0,
                                ];

        $expectedResult     =   [ 
                                    1,
                                    ];

        $this->assertSame($result,$expectedResult);           
    }

    
}