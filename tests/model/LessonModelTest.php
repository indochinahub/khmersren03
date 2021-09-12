<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class LessonModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->lesson_model = new LessonModel();

    }

    // return array of object
    public function test_get_by_course_id(){

        $result1 = $this->lesson_model->get_by_course_id($course_id = 0);
        $result2 = $this->lesson_model->get_by_course_id($course_id = 1);

        $result         =   [ 
                                $result1,
                                count($result2) > 0 ,

                            ];
        $expectedResult =   [
                                [],
                                true
                            ];
        $this->assertSame($expectedResult, $result);        
    }   
    
    public function test_get_thumbnail_url(){

        $result1 = $this->lesson_model->get_thumbnail_url($file_name = "000011.jpg");
        $result2 = $this->lesson_model->get_thumbnail_url($file_name = "");

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [
                                "http://127.0.0.1/khmersren03/asset/media/course_media/000011.jpg",
                                "http://127.0.0.1/khmersren03/asset/media/course_media/default_unread_lesson_thumbnail.jpg"
                                 
                            ];
        $this->assertSame($expectedResult, $result);        
    }
   
}