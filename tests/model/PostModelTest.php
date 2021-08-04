<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\CardModel;

class PostModelTest extends CIUnitTestCase
{
    var $post_model;


    public function setUp(): void
    {
        parent::setUp();
        $this->post_model = new PostModel();
    }

    // return assoc_array
    public function test_get_assoc_media_html(){

        $obj_post = new \stdClass;
        $obj_post->post_picture01   = "000231.jpg";
        $obj_post->post_picture02   = "000232.jpg";
        $obj_post->post_picture03   = "000233.jpg";
        $obj_post->post_picture04   = "000234.jpg";
        $obj_post->post_picture05   = "000235.jpg";
        $obj_post->post_picture06   = "000236.jpg";
        $obj_post->post_sound01     = "000231.mp3";
        $obj_post->post_sound02     = "000232.mp3";
        $obj_post->post_youtube01   = "1c9jcCS_KKQ";
        $obj_post->post_youtube02   = "I6j1838RI2Q";
        $obj_post->post_youtube03   = "y8QbACaKGBo";
        $obj_post->post_youtube04   = "OutbRXSYjoQ";

        $result1 = $this->post_model->get_assoc_media_html($obj_post);

        $obj_post = new \stdClass;
        $obj_post->post_picture01   = null;
        $obj_post->post_picture02   = null;
        $obj_post->post_picture03   = null;
        $obj_post->post_picture04   = null;
        $obj_post->post_picture05   = null;
        $obj_post->post_picture06   = null;
        $obj_post->post_sound01     = null;
        $obj_post->post_sound02     = null;
        $obj_post->post_youtube01   = null;
        $obj_post->post_youtube02   = null;
        $obj_post->post_youtube03   = null;
        $obj_post->post_youtube04   = null;

        $result2 = $this->post_model->get_assoc_media_html($obj_post);

        $result         =   [   
                                //result01
                                $result1["[picture01]"],
                                $result1["[picture02]"],
                                $result1["[picture03]"],
                                $result1["[picture04]"],
                                $result1["[picture05]"],
                                $result1["[picture06]"],

                                $result1["[youtube01]"],
                                $result1["[youtube02]"],
                                $result1["[youtube03]"],
                                $result1["[youtube04]"],

                                $result1["[sound01]"],
                                $result1["[sound02]"],

                                //result02

                                $result2["[picture01]"],
                                $result2["[picture02]"],
                                $result2["[picture03]"],
                                $result2["[picture04]"],
                                $result2["[picture05]"],
                                $result2["[picture06]"],

                                $result2["[youtube01]"],
                                $result2["[youtube02]"],
                                $result2["[youtube03]"],
                                $result2["[youtube04]"],

                                $result2["[sound01]"],
                                $result2["[sound02]"],                                

                            ];

        $expectedResult =   [ 
                                //result01
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000232.jpg' class='img-fluid'></div>",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000233.jpg' class='img-fluid'></div>",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000234.jpg' class='img-fluid'></div>",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000235.jpg' class='img-fluid'></div>",
                                "<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000236.jpg' class='img-fluid'></div>",

                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/1c9jcCS_KKQ' allowfullscreen=''></iframe></div></div>",
                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/I6j1838RI2Q' allowfullscreen=''></iframe></div></div>",
                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/y8QbACaKGBo' allowfullscreen=''></iframe></div></div>",
                                "<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/OutbRXSYjoQ' allowfullscreen=''></iframe></div></div>",

                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000232.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000232.mp3'>[ Listen Directly ]</a></div>",

                                //result02
                                false,
                                false,
                                false,
                                false,                                
                                false,
                                false,                                
                                false,
                                false,                                
                                false,
                                false,                                
                                false,
                                false,

                            ];

        $this->assertSame($expectedResult, $result);        
    }

    // return object
    public function test_add_media_to_post(){


        // Picture
        $obj_post = new \stdClass;

        $obj_post->post_picture01   = "000231.jpg";
        $obj_post->post_picture02   = "000232.jpg";
        $obj_post->post_picture03   = "000233.jpg";
        $obj_post->post_picture04   = "000234.jpg";
        $obj_post->post_picture05   = "000235.jpg";
        $obj_post->post_picture06   = "000236.jpg";
        $obj_post->post_sound01     = "000231.mp3";
        $obj_post->post_sound02     = "000232.mp3";
        $obj_post->post_youtube01   = "1c9jcCS_KKQ";
        $obj_post->post_youtube02   = "I6j1838RI2Q";
        $obj_post->post_youtube03   = "y8QbACaKGBo";
        $obj_post->post_youtube04   = "OutbRXSYjoQ";

        $obj_post->post_intro       = "xx[picture01]";
        $obj_post->post_content     = "yy[picture02]";

        $result1 = $this->post_model->add_media_to_post($obj_post);

        // Youtube
        $obj_post = new \stdClass;

        $obj_post->post_picture01   = "000231.jpg";
        $obj_post->post_picture02   = "000232.jpg";
        $obj_post->post_picture03   = "000233.jpg";
        $obj_post->post_picture04   = "000234.jpg";
        $obj_post->post_picture05   = "000235.jpg";
        $obj_post->post_picture06   = "000236.jpg";
        $obj_post->post_sound01     = "000231.mp3";
        $obj_post->post_sound02     = "000232.mp3";
        $obj_post->post_youtube01   = "1c9jcCS_KKQ";
        $obj_post->post_youtube02   = "I6j1838RI2Q";
        $obj_post->post_youtube03   = "y8QbACaKGBo";
        $obj_post->post_youtube04   = "OutbRXSYjoQ";
        
        $obj_post->post_intro       = "xx[youtube01]";
        $obj_post->post_content     = "yy[youtube02]";

        $result2 = $this->post_model->add_media_to_post($obj_post);

        // Sound
        $obj_post = new \stdClass;

        $obj_post->post_picture01   = "000231.jpg";
        $obj_post->post_picture02   = "000232.jpg";
        $obj_post->post_picture03   = "000233.jpg";
        $obj_post->post_picture04   = "000234.jpg";
        $obj_post->post_picture05   = "000235.jpg";
        $obj_post->post_picture06   = "000236.jpg";
        $obj_post->post_sound01     = "000231.mp3";
        $obj_post->post_sound02     = "000232.mp3";
        $obj_post->post_youtube01   = "1c9jcCS_KKQ";
        $obj_post->post_youtube02   = "I6j1838RI2Q";
        $obj_post->post_youtube03   = "y8QbACaKGBo";
        $obj_post->post_youtube04   = "OutbRXSYjoQ";
        
        $obj_post->post_intro       = "xx[sound01]";
        $obj_post->post_content     = "yy[sound02]";

        $result3 = $this->post_model->add_media_to_post($obj_post);

        $result         =   [   
                                $result1->post_intro,
                                $result1->post_content,

                                $result2->post_intro,
                                $result2->post_content,

                                $result3->post_intro,
                                $result3->post_content,                                
                            ];
        $expectedResult =   [ 
                                "xx<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.jpg' class='img-fluid'></div>",
                                "yy<div style='border:1px solid black'><img src='http://127.0.0.1/khmersren03/asset/media/post_media/000232.jpg' class='img-fluid'></div>",

                                "xx<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/1c9jcCS_KKQ' allowfullscreen=''></iframe></div></div>",
                                "yy<div style='margin-bottom:15px'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/I6j1838RI2Q' allowfullscreen=''></iframe></div></div>",

                                "xx<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000231.mp3'>[ Listen Directly ]</a></div>",
                                "yy<div><audio controls=''><source src='http://127.0.0.1/khmersren03/asset/media/post_media/000232.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/media/post_media/000232.mp3'>[ Listen Directly ]</a></div>",                                    
                            ];
        $this->assertSame($expectedResult, $result);                


    }    

    
}