<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class MediaModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    // return array of picture
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
                                $result1[0]->media_order,
                                $result1[0]->media_tag,
                                $result1[0]->html,
                                $result1[0]->property,
                                $result1[0]->value,

                                // $result2
                                count($result2),
                                $result1[0]->media_order,
                                $result2[0]->media_tag,
                                $result2[0]->html,
                                $result2[0]->property,
                                $result2[0]->value,

                            ];
        $expectedResult =   [   // $result1
                                6,
                                1,
                                "[picture01]",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "post_picture01",
                                "000231.jpg",

                                // $result2
                                2,
                                1,
                                "[picture01]",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "post_picture01",
                                "000231.jpg",                                
                            ];
        $this->assertSame($expectedResult, $result);                
    }

    // return array of sound
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
                                $result1[0]->media_order,
                                $result1[0]->media_tag,
                                $result1[0]->html,
                                $result1[0]->property,
                                $result1[0]->value,

                                // $result2
                                count($result2),
                                $result2[0]->media_order,
                                $result2[0]->media_tag,
                                $result2[0]->html,
                                $result2[0]->property,
                                $result2[0]->value,
                            ];
        $expectedResult =   [   // $result1   
                                2,
                                1,
                                "[sound01]",
                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "post_sound01",
                                "000231.mp3",

                                // $result2
                                1, 
                                1,
                                "[sound01]",
                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "post_sound01",
                                "000231.mp3",
                            ];
        $this->assertSame($expectedResult, $result);       

    }    

    // return array of youtube
    public function test_get_arr_youtube(){

        $obj = new \stdClass;
        $obj->post_youtube01   = "1c9jcCS_KKQ";
        $obj->post_youtube02   = "I6j1838RI2Q";
        $obj->post_youtube03   = "y8QbACaKGBo";
        $obj->post_youtube04   = "OutbRXSYjoQ";

        $media_model = new MediaModel($obj, "post");
        $result1 = $media_model->get_arr_youtube();        

        // There is only one name;value pair
        $obj = new \stdClass;
        $obj->post_youtube01   = "1c9jcCS_KKQ";

        $media_model = new MediaModel($obj, "post");
        $result2 = $media_model->get_arr_youtube();        

        $result         =   [   // $result1
                                count($result1),
                                $result1[0]->media_order,
                                $result1[0]->media_tag,
                                $result1[0]->html,
                                $result1[0]->property,
                                $result1[0]->value,

                                // $result1
                                count($result2),
                                $result2[0]->media_order,
                                $result2[0]->media_tag,
                                $result2[0]->html,
                                $result2[0]->property,
                                $result2[0]->value,

                            ];
        $expectedResult =   [   // $result1   
                                4,
                                1,
                                "[youtube01]",
                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/1c9jcCS_KKQ' allowfullscreen=''></iframe></div></div>",
                                "post_youtube01",
                                "1c9jcCS_KKQ",

                                // $result1
                                1,
                                1,
                                "[youtube01]",
                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/1c9jcCS_KKQ' allowfullscreen=''></iframe></div></div>",
                                "post_youtube01",
                                "1c9jcCS_KKQ",
                            ];
        $this->assertSame($expectedResult, $result);       
    }

    // return text
    public function test_replace_media_tag_with_html(){

        $obj = new \stdClass;
        $obj->post_picture01   = "000231.jpg";
        $obj->post_picture02   = "000232.jpg";
        $obj->post_picture03   = "000233.jpg";
        $obj->post_picture04   = "000234.jpg";
        $obj->post_picture05   = "000235.jpg";
        $obj->post_picture06   = "000236.jpg";

        $obj->post_sound01     = "000231.mp3";
        $obj->post_sound02     = "000232.mp3";

        $obj->post_youtube01   = "1c9jcCS_KKQ";
        $obj->post_youtube02   = "I6j1838RI2Q";
        $obj->post_youtube03   = "y8QbACaKGBo";
        $obj->post_youtube04   = "OutbRXSYjoQ";

        $media_model = new MediaModel($obj, "post");
        $result1 = $media_model->replace_media_tag_with_html($text = "xx[picture01]");
        $result2 = $media_model->replace_media_tag_with_html($text = "yy[sound01]");
        $result3 = $media_model->replace_media_tag_with_html($text = "zz[youtube01]");

        $result         =   [   // $result1
                                $result1,
                                $result2,
                                $result3,
                            ];
        $expectedResult =   [   // $result1   
                                "xx<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "yy<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "zz<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/1c9jcCS_KKQ' allowfullscreen=''></iframe></div></div>",                                
                            ];
        $this->assertSame($expectedResult, $result);       

    }



   
}