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

    // return int
    public function test_get_num_by_cardgroup_id(){

        $result1 = $this->card_model->get_num_by_cardgroup_id($cardgroup_id = 1);
        $result2 = $this->card_model->get_num_by_cardgroup_id($cardgroup_id = 0);
        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [
                                15,
                                0,
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
                                    "<div>Picture is not found : E:\\xampp\htdocs\khmersren03\asset/course/T001/image/vvvvv.jpg </div>",
                                ];

        $this->assertSame($result,$expectedResult);

    }    

    // return array of object
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
    
        // With Null parameter
        $deck = new \stdClass;
        $deck->deck_command1_col = "card_text1";
        $deck->deck_command2_col = "card_text2";
        $deck->deck_command3_col = "card_text3";
        $deck->deck_command4_col = null;

        $result2  = $this->card_model->get_card_command($card, $course, $deck);

        // With not complete parameter
        // There is no deck_command3_col and deck_command4_col
        $deck = new \stdClass;
        $deck->deck_command1_col = "card_text1";
        $deck->deck_command2_col = "card_text2";

        $result3  = $this->card_model->get_card_command($card, $course, $deck);

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
        
        // asserttion
        $result             =   [   // result1
                                    [$result1[0]->html , $result1[0]->value, $result1[0]->column_name],
                                    [$result1[1]->html , $result1[1]->value, $result1[1]->column_name],
                                    [$result1[2]->html , $result1[2]->value, $result1[2]->column_name],
                                    [$result1[3]->html , $result1[3]->value, $result1[3]->column_name],

                                    // result2
                                    [$result2[0]->html , $result2[0]->value, $result2[0]->column_name],
                                    [$result2[1]->html , $result2[1]->value, $result2[1]->column_name],
                                    [$result2[2]->html , $result2[2]->value, $result2[2]->column_name],
                                    $result2[3],

                                    // result3
                                    [$result3[0]->html , $result3[0]->value, $result3[0]->column_name],
                                    [$result3[1]->html , $result3[1]->value, $result3[1]->column_name],
                                    $result3[2],
                                    $result3[3],

                                    // result4
                                    [   $result4[0]->html , 
                                        $result4[0]->value, 
                                        $result4[0]->column_name
                                    ],
                                    [   $result4[1]->html , 
                                        $result4[1]->value, 
                                        $result4[1]->column_name
                                    ],                                    
                                    $result4[2],
                                    $result4[3],

                            


                                ];
        $expectedResult     =   [   // result1
                                    ["This is Text1", "This is Text1", "card_text1"],
                                    ["This is Text2","This is Text2","card_text2"],
                                    ["This is Text3","This is Text3","card_text3"],
                                    ["This is Text4","This is Text4","card_text4"],

                                    // result2
                                    ["This is Text1", "This is Text1", "card_text1"],
                                    ["This is Text2", "This is Text2", "card_text2"],
                                    ["This is Text3", "This is Text3", "card_text3"],
                                    false,

                                    // result3
                                    ["This is Text1", "This is Text1", "card_text1"],
                                    ["This is Text2", "This is Text2", "card_text2"],
                                    false,
                                    false,

                                    // result4
                                    [
                                        "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                        "card_picture1.jpg",
                                        "card_picture1",
                                    ],                                    

                                    [
                                        "<audio controls><source src='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3'>[ Listen Directly ]</a>",
                                        "card_sound1.mp3",
                                        "card_sound1" 
                                    ],
                                    false,
                                    false



                                ];

        $this->assertSame($result,$expectedResult);
    }

    //return array of object
    public function test_get_card_choice(){

        // Complete parameters
        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;
        $deck->deck_choice1a_col = "card_picture1";
        $deck->deck_choice1b_col = "card_sound1";

        $deck->deck_choice1c_col = "card_text3";
        $deck->deck_choice1d_col = "card_text4";
        $deck->deck_choice2a_col = "card_text5";
        $deck->deck_choice2b_col = "card_text6";
        $deck->deck_choice2c_col = "card_text7";
        $deck->deck_choice2d_col = "card_text8";
        $deck->deck_choice3a_col = "card_text9";
        $deck->deck_choice3b_col = "card_text10";
        $deck->deck_choice3c_col = "card_text11";
        $deck->deck_choice3d_col = "card_text12";
        $deck->deck_choice4a_col = "card_text13";
        $deck->deck_choice4b_col = "card_text14";
        $deck->deck_choice4c_col = "card_text15";
        $deck->deck_choice4d_col = "card_text16";

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

        $result1 = $this->card_model->get_card_choice(
                                $card, 
                                $course, 
                                $deck, 
                                $key_of_choices
                            );

        // In case some values in card are empty
        $deck = new \stdClass;
        $deck->deck_choice1a_col = "card_picture1";
        $deck->deck_choice1b_col = "card_sound1";

        $card = new \stdClass;
        $card->card_picture1    = "card_picture1.jpg";
        $card->card_sound1      = "";   
        
        $key_of_choices = [ 3, 0, 1, 2];        

        $result2 = $this->card_model->get_card_choice(
                                $card, 
                                $course, 
                                $deck, 
                                $key_of_choices
                            );

        $result             =   [      
                                    // result1 choice 1     
                                    $result1[0]->a->html,
                                    $result1[0]->a->value,       
                                    $result1[0]->a->column_name,

                                    $result1[0]->b->html,
                                    $result1[0]->b->value,       
                                    $result1[0]->b->column_name,     
                                    
                                    $result1[0]->c->html,
                                    $result1[0]->c->value,       
                                    $result1[0]->c->column_name,   
            
                                    $result1[0]->c->html,
                                    $result1[0]->c->value,       
                                    $result1[0]->c->column_name,    

                                    $result1[0]->key,

                                    // result1 choice 2
                                    $result1[1]->a->html,
                                    $result1[1]->a->value,       
                                    $result1[1]->a->column_name,

                                    $result1[1]->key,

                                    // result2 choice 2                                    
                                    $result2[1]->a->html,
                                    $result2[1]->a->value,
                                    $result2[1]->a->column_name,

                                    $result2[1]->b,
                                    $result2[1]->c,
                                    $result2[1]->d,
                                ];

        $expectedResult     =   [
                                    // result1 choice 1
                                    "This is Text13",
                                    "This is Text13",
                                    "card_text13",

                                    "This is Text14",
                                    "This is Text14",
                                    "card_text14",

                                    "This is Text15",
                                    "This is Text15",
                                    "card_text15",
                                    
                                    "This is Text15",
                                    "This is Text15",
                                    "card_text15",
                                    
                                    3,

                                    // result1 choice 2
                                    "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                    "card_picture1.jpg",
                                    "card_picture1",

                                    0,

                                    // result2 choice 2                                         
                                    "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                    "card_picture1.jpg",
                                    "card_picture1",

                                    false,
                                    false,
                                    false,
                                ];

        $this->assertSame($result,$expectedResult);        
    }

    //return array of object
    public function test_get_card_answer(){

        // Complete parameters
        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;
        $deck->deck_choice1a_col = "card_picture1";
        $deck->deck_choice1b_col = "card_sound1";

        $deck->deck_answer1_col = "card_text1";
        $deck->deck_answer2_col = "card_picture1";
        $deck->deck_answer3_col = "card_sound1";

        $card = new \stdClass;
        $card->card_text1       = "This is Text1";
        $card->card_picture1    = "card_picture1.jpg";
        $card->card_sound1      = "card_sound1.mp3";

        $result1 =  $this->card_model->get_card_answer(
                            $card, 
                            $course, 
                            $deck
                        );

        // In case some card values are emty

        $course = new \stdClass;
        $course->course_code = "T001";

        $deck = new \stdClass;

        $deck->deck_answer1_col = "card_text1";
        $deck->deck_answer2_col = "card_picture1";
        $deck->deck_answer3_col = "card_sound1";

        $card = new \stdClass;
        $card->card_text1       = "";
        $card->card_picture1    = "";
        $card->card_sound1      = "";

        $result2 =  $this->card_model->get_card_answer(
                        $card, 
                        $course, 
                        $deck
                    );

        $result             =   [   // result1
                                    $result1[0]->html,
                                    $result1[0]->value,
                                    $result1[0]->column_name,

                                    $result1[1]->html,
                                    $result1[1]->value,
                                    $result1[1]->column_name,

                                    $result1[2]->html,
                                    $result1[2]->value,
                                    $result1[2]->column_name,

                                    // result2
                                    $result2[0],
                                    $result2[1],
                                    $result2[2],
                                ];
        $expectedResult     =   [   // result1
                                    "This is Text1",
                                    "This is Text1",
                                    "card_text1",

                                    "<div><img src='http://127.0.0.1/khmersren03/asset/course/T001/image/card_picture1.jpg' class='img-fluid'></div>",
                                    "card_picture1.jpg",
                                    "card_picture1",                                    
                            
                                    "<audio controls><source src='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3' type='audio/mpeg'></audio><br><a href='http://127.0.0.1/khmersren03/asset/course/T001/sound/card_sound1.mp3'>[ Listen Directly ]</a>",
                                    "card_sound1.mp3",
                                    "card_sound1",

                                    // result2
                                    false,
                                    false,
                                    false,
                                    
                                ];
        $this->assertSame($result,$expectedResult);                
    }

    //return insertedId
    public function test_insert_blank_card(){

        $result1 = $this->card_model->insert_blank_card();

        $result             =   [
                                    $result1 > 0
                                ];
        $expectedResult     =   [   
                                    true
                                ];
        $this->assertSame($result,$expectedResult);

        $sql = " DELETE FROM card WHERE card_id = $result1 ";
        $this->card_model->query($sql);                

    }
    
}