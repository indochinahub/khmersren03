<?php

namespace App\Library;

use CodeIgniter\Test\CIUnitTestCase;

class MyHelperTest extends CIUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        helper(["my"]);
    }    

    public function test_get_text_of_minute_and_hour_by_second(){

        $result1 = get_text_of_minute_and_hour_by_second($second= 45);
        $result2 = get_text_of_minute_and_hour_by_second($second= 60);
        $result3 = get_text_of_minute_and_hour_by_second($second= 85);
        $result4 = get_text_of_minute_and_hour_by_second($second= 3600);
        $result5 = get_text_of_minute_and_hour_by_second($second= 3750);

        $result             =   [   
                                    $result1,
                                    $result2,
                                    $result3,
                                    $result4,
                                    $result5,
                                ];
        $expectedResult     =   [ 
                                    "45 วินาที",
                                    "1 นาที",
                                    "1 นาที",
                                    "1 ชั่วโมง",
                                    "1.04 ชั่วโมง",
                                ];
        $this->assertSame($result,$expectedResult);    
    }

    // return text
    function test_get_userlevel_text(){

        $result01 = get_userlevel_text($user_level = 1);
        $result02 = get_userlevel_text($user_level = 2);
        $result03 = get_userlevel_text($user_level = 3);

        $result             =   [ 
                                    $result01,
                                    $result02,
                                    $result03,
                                ];
        $expectedResult     =   [ 
                                    "ผู้เรียน",
                                    "ครู",
                                    "ผู้ดูแลระบบ",
                                ];

        $this->assertSame($result,$expectedResult);
    }    

}