<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class CourseModelTest extends CIUnitTestCase
{
    var $course_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->course_model = new CourseModel;

    }

    // return Object Or false
    public function test_get_by_cardgroup_id(){

        $result1 = $this->course_model->get_by_cardgroup_id($cardgroup_id = 0);
        $result2 = $this->course_model->get_by_cardgroup_id($cardgroup_id = 1);

        $result             =   [ 
                                    $result1,
                                    $result2->course_code,
                                ];

        $expectedResult     =   [   
                                    false,
                                    "T001",
                                ];

        $this->assertSame($result,$expectedResult);        
    }


    // return object or false
    public function test_get_by_deck_id(){

        $result1 = $this->course_model->get_by_deck_id($deck_id = 0);
        $result2 = $this->course_model->get_by_deck_id($deck_id = 1);

        $result             =   [ 
                                    $result1,
                                    $result2->course_code,
                                ];

        $expectedResult     =   [ 
                                    false,
                                    "T001",
                                ];

        $this->assertSame($result,$expectedResult);
    }

    //return array_of_object
    public function test_get_by_coursetype_id(){

        $result1 = $this->course_model->get_by_coursetype_id($coursetype_id = 3);
        $result2 = $this->course_model->get_by_coursetype_id($coursetype_id = 0);

        $result             =   [ 
                                    count($result1) > 0,
                                    $result2,
                                ];

        $expectedResult     =   [ 
                                    true,
                                    [],
                                ];

        $this->assertSame($result,$expectedResult);
    }

    //return url
    public function test_get_thumbnail_url(){

        $result1 = $this->course_model->get_thumbnail_url($file_name = "000011.jpg");
        $result2 = $this->course_model->get_thumbnail_url($file_name = "");

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    "http://127.0.0.1/khmersren03/asset/media/course_media/000011.jpg",
                                    "http://127.0.0.1/khmersren03/asset/media/course_media/default_course_thumbnail.jpg"
                                ];
        $this->assertSame($result,$expectedResult);            
    }


}