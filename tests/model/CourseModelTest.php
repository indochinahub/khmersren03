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

    // return URL text
    public function test_get_icon_url(){
        
        $course_obj = new \stdClass;

        $course_obj->course_code = "T001";
        $result1 = $this->course_model->get_icon_url($course_obj);

        $course_obj->course_code = "xxx";
        $result2 = $this->course_model->get_icon_url($course_obj);        

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];

        $expectedResult     =   [ 
                                    "http://127.0.0.1/khmersren03/asset/course/T001/course_thumbnail.jpg",
                                    "http://127.0.0.1/khmersren03/asset/course/course_thumbnail.jpg",

                                ];

        $this->assertSame($result,$expectedResult);
    }
        
        

    
    
}