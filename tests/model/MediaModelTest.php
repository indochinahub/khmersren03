<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class MediaModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }


    // return array of text
    public function test_get_picture_property(){

        
        $obj = new \stdClass;
        $obj->post_picture01   = "000231.jpg";
        $obj->post_picture02   = "000232.jpg";
        $obj->post_picture03   = "000233.jpg";
        $obj->post_picture04   = "000234.jpg";
        $obj->post_picture05   = "000235.jpg";
        $obj->post_picture06   = "000236.jpg";

        $media_model = new MediaModel($obj, "post");
        $result1 = $media_model->get_arr_picture();        

        // Only 2 property-value
        $obj = new \stdClass;
        $obj->post_picture01   = "000231.jpg";
        $obj->post_picture02   = "000232.jpg";

        $media_model = new MediaModel($obj, "post");
        $result2 = $media_model->get_arr_picture();

        $result         =   [   // $result1
                                count($result1),
                                $result1[0]->media_tag,
                                $result1[0]->html,
                                $result1[0]->property,
                                $result1[0]->value,

                                // $result2
                                count($result2),
                                $result2[0]->media_tag,
                                $result2[0]->html,
                                $result2[0]->property,
                                $result2[0]->value,

                            ];
        $expectedResult =   [   // $result1
                                6,
                                "[picture01]",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "post_picture01",
                                "000231.jpg",

                                // $result2
                                2,
                                "[picture01]",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "post_picture01",
                                "000231.jpg",                                
                            ];
        $this->assertSame($expectedResult, $result);                
    }

    // return array of text
    public function test_get_arr_sound(){

        $obj = new \stdClass;
        $obj->post_sound01     = "000231.mp3";
        $obj->post_sound02     = "000232.mp3";        

        $media_model = new MediaModel($obj, "post");
        $result1 = $media_model->get_arr_sound();

        // There is only a name:value pair
        $obj = new \stdClass;
        $obj->post_sound01     = "000231.mp3";

        $media_model = new MediaModel($obj, "post");
        $result2 = $media_model->get_arr_sound();

        $result         =   [   // $result1
                                count($result1),
                                $result1[0]->media_tag,
                                $result1[0]->html,
                                $result1[0]->property,
                                $result1[0]->value,

                                // $result2
                                count($result2),
                                $result2[0]->media_tag,
                                $result2[0]->html,
                                $result2[0]->property,
                                $result2[0]->value,
                            ];
        $expectedResult =   [   // $result1   
                                2,
                                "[sound01]",
                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "post_sound01",
                                "000231.mp3",

                                // $result2
                                1, 
                                "[sound01]",
                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "post_sound01",
                                "000231.mp3",
                            ];
        $this->assertSame($expectedResult, $result);       

    }    






   
}