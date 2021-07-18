<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\CardModel;

class CardModelTest extends CIUnitTestCase
{
    var $card_model;
    var $card_sample;

    public function setUp(): void
    {
        parent::setUp();
        $this->card_model = new CardModel();

        $card_sample = new \stdClass;


    }

    // return array of card or blank array
    public function test_get_by_cardgroup_id(){

        $result1 = $this->card_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result2 = $this->card_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result             =   [ 
                                    count($result1),
                                    $result2
                                ];
        $expectedResult     =   [ 
                                    15,
                                    [],
                                ];

        $this->assertSame($result,$expectedResult);                
    }

    // return array Of object Or blank array
    public function test_get_by_deck_id(){
        $card_model = new CardModel();
        
        $result1 = $card_model->get_by_deck_id($deck_id = 1 );
        $result2 = $card_model->get_by_deck_id($deck_id = 0 );

        $result             =   [ 
                                    count($result1),
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    15,
                                    [],
                                ];

        $this->assertSame($result,$expectedResult);        

    }

    // return id int
    public function test_get_next_card_id_to_review(){

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result1 = $this->card_model->get_next_card_id_to_review(
                                    $deck_id = 1, 
                                    $user_id = 1, 
                                    $unix_timestamp= 1582567200
                                );

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result2 = $this->card_model->get_next_card_id_to_review(
                                    $deck_id = 0, 
                                    $user_id = 1, 
                                    $unix_timestamp= 1582567200
                                );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    3,
                                    false,
                                ];
        $this->assertSame($result,$expectedResult);    

    }

    // return id int or false
    public function test_get_new_card_id_to_learn(){

        // sqlTimeStamp = '2020-02-25 01:00:00' :: unix_timestamp 1582567200
        $result1 = $this->card_model->get_new_card_id_to_learn(
                                    $deck_id = 1, 
                                    $user_id = 1, 
                                    $unix_timestamp = 1582567200
                                );

        // sqlTimeStamp = '2020-02-25 01:00:00' :: unix_timestamp 1582567200
        $result2 = $this->card_model->get_new_card_id_to_learn(
                                    $deck_id = 0, 
                                    $user_id = 0, 
                                    $unix_timestamp = 1582567200
                                );                                

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];

        $expectedResult     =   [ 
                                    13,
                                    false,
                                ];

        $this->assertSame($result,$expectedResult);    
    }

    // return int of false
    public function test_get_next_card_id(){

        $result1 = $this->card_model->get_next_card_id(
                                $deck_id = 1,
                                $user_id = 1,
                                $unix_timestamp = time()
                                );

        $result             =   [ 
                                    $result1,
                                ];

        $expectedResult     =   [ 
                                    3,
                                ];

        $this->assertSame($result,$expectedResult);
    }

    //return html text
    public function test_get_card_value_in_html(){

        // Complete parameters
        $course = new \stdClass;
        $course->course_code = "T001";        

        // there is not valid card_property
        $result01 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "xxxxx",
                                $card_value = "This is text1." );

        // For card_text..[]..
        $result02 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "card_text1",
                                $card_value = "This is text1." );
        // For card_youtube..[]..
        $result03 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "card_youtube",
                                $card_value = "AmKZUZ9clKs" );
        // For card_sound..[]..
        $result04 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "card_sound1",
                                $card_value = "card_sound1.mp3" );

        // For card_picture..[]..
        $result05 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "card_picture1",
                                $card_value = "card_picture1.jpg" );

        $result06 = $this->card_model->get_card_value_in_html(
                                $course,
                                $card_property = "card_picture1",
                                $card_value = "vvvvv.jpg" );                                

        
        $result             =   [ 
                                    $result01,
                                    $result02,
                                    $result03,
                                    $result04,
                                    $result05,
                                    $result06,
                                ];

        $expectedResult     =   [ 
                                    false,
                                    "This is text1.",
                                    "<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/AmKZUZ9clKs' allowfullscreen></iframe></div>",
                                    "<audio controls><source src='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3'>[ Listen Directly ]</a>",
                                    "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                    "<div>Picture is not found : F:\\xampp\htdocs\khmersren03\asset/course/T001/image/vvvvv.jpg </div>",
                                ];

        $this->assertSame($result,$expectedResult);

    }    

    // return array
    public function test_get_card_command(){

        // Complete parameters

        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;
        $deck->deck_command1_col = "card_text1";
        $deck->deck_command2_col = "card_text2";
        $deck->deck_command3_col = "card_text3";
        $deck->deck_command4_col = "card_text4";

        $card = new \stdClass;
        $card->card_text1 = "This is Text1";
        $card->card_text2 = "This is Text2";
        $card->card_text3 = "This is Text3";
        $card->card_text4 = "This is Text4";

        $result1  = $this->card_model->get_card_command($card, $course, $deck);
    /**************************************************************************************/
        // With Null parameter
        $deck = new \stdClass;
        $deck->deck_command1_col = "card_text1";
        $deck->deck_command2_col = "card_text2";
        $deck->deck_command3_col = "card_text3";
        $deck->deck_command4_col = null;

        $result2  = $this->card_model->get_card_command($card, $course, $deck);
    /**************************************************************************************/        
        // With not complete parameter
        // There is no deck_command3_col and deck_command4_col
        $deck = new \stdClass;
        $deck->deck_command1_col = "card_text1";
        $deck->deck_command2_col = "card_text2";

        $result3  = $this->card_model->get_card_command($card, $course, $deck);
    /**************************************************************************************/            

        // With not complete parameter
        // There is no deck_command3_col and deck_command4_col
        // The values is sound and picture media
        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;
        $deck->deck_command1_col = "card_picture1";
        $deck->deck_command2_col = "card_sound1";    

        $card = new \stdClass;
        $card->card_picture1 = "card_picture1.jpg";
        $card->card_sound1 = "card_sound1.mp3";
        
        $result4  = $this->card_model->get_card_command($card, $course, $deck);

    /**************************************************************************************/            

        $result             =   [ 
                                    $result1,
                                    $result2,
                                    $result3,
                                    $result4,
                                ];
        $expectedResult     =   [ 
                                    ["This is Text1", "This is Text2", "This is Text3", "This is Text4"],
                                    ["This is Text1", "This is Text2", "This is Text3", false],
                                    ["This is Text1", "This is Text2", false, false],

                                    [
                                        "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                        "<audio controls><source src='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3'>[ Listen Directly ]</a>",
                                        false,
                                        false,
                                    ]
                                ];

        $this->assertSame($result,$expectedResult);
    }

    //return array of object
    public function test_get_card_choice(){

        // Complete parameters
        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;
        $deck->choice1a = "card_picture1";
        $deck->choice1b = "card_sound1";

        $deck->choice1c = "card_text3";
        $deck->choice1d = "card_text4";
        $deck->choice2a = "card_text5";
        $deck->choice2b = "card_text6";
        $deck->choice2c = "card_text7";
        $deck->choice2d = "card_text8";
        $deck->choice3a = "card_text9";
        $deck->choice3b = "card_text10";
        $deck->choice3c = "card_text11";
        $deck->choice3d = "card_text12";
        $deck->choice4a = "card_text13";
        $deck->choice4b = "card_text14";
        $deck->choice4c = "card_text15";
        $deck->choice4d = "card_text16";

        $card = new \stdClass;
        $card->card_picture1    = "card_picture1.jpg";
        $card->card_sound1      = "card_sound1.mp3";

        $card->card_text3 = "This is Text3";
        $card->card_text4 = "This is Text4";
        $card->card_text5 = "This is Text5";
        $card->card_text6 = "This is Text6";
        $card->card_text7 = "This is Text7";
        $card->card_text8 = "This is Text8";
        $card->card_text9 = "This is Text9";
        $card->card_text10 = "This is Text10";
        $card->card_text11 = "This is Text11";
        $card->card_text12 = "This is Text12";
        $card->card_text13 = "This is Text13";
        $card->card_text14 = "This is Text14";
        $card->card_text15 = "This is Text15";        
        $card->card_text16 = "This is Text16";  
        
        $key_of_choices = [ 3, 0, 1, 2];

        //
        $result1 = $this->card_model->get_card_choice(
                            $card, 
                            $course, 
                            $deck, 
                            $key_of_choices
                        );

        $result             =   [ 
                                    $result1[1]->a,
                                    $result1[1]->b,
                                ];
        $expectedResult     =   [
                                    "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                    "<audio controls><source src='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3'>[ Listen Directly ]</a>",
                                ];
        $this->assertSame($result,$expectedResult);        
    }

    
}