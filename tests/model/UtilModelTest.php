<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UtilModelTest extends CIUnitTestCase
{

    var $util_model;

    public function __construct(){
        parent::__construct();
        $this->util_model = new UtilModel();
    }

    public function test_get_class_from_fullname()
    {
        $result1 = $this->util_model->get_class_from_fullname("\Apps\Test\MyClass");
        $result2 = $this->util_model->get_class_from_fullname("Apps\Test\MyClass");
        
        $result             =   [ $result1, $result2 ];
        $expectedResult     =   [ "MyClass", "MyClass" ];

        $this->assertSame($result,$expectedResult);
        
    }

    public function test_get_object_from_arr_object_with_pointer_by_key_id(){

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        // Return false
        $result01 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = [], 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result02 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "", 
                            $key_id = "1"
                        );
        $result03 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = ""
                        );                        
        $result04 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result05 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "2"
                        );                        
        $result06 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "3"
                        );                             

        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04->previous_id, //id = 1
                                $result04->next_id,
                                $result05->previous_id, //id = 2
                                $result05->next_id,
                                $result06->previous_id, //id = 3
                                $result06->next_id,
                            ];

        $expectedResult =   [   FALSE,
                                FALSE,
                                FALSE,
                                FALSE,  //id = 1
                                2,
                                1,  //id = 2
                                3,
                                2,  //id = 3
                                FALSE,                                                                
                            ];                                

        $this->assertSame($result,$expectedResult);                        
    }

    public function test_get_assoc_from_array_of_object(){

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        $result01 =  $this->util_model->get_assoc_from_array_of_object(
                        $arr_object = $arr_student, 
                        $key_property = "id"
                    );

        $result         =   [   count($result01),
                                is_object($result01["1"]),
                                $result01["1"]->name,
                            ];

        $expectedResult =   [   3,
                                TRUE,
                                "Wittaya",
                            ];                                

        $this->assertSame($result,$expectedResult);
    }

    public function test_get_line_of_text_with_saparator_from_array(){

        $arrs = ["text1","text2","text3"];
        $saparator = "---";
        $result01 =  $this->util_model->get_line_of_text_with_saparator_from_array($arrs, $saparator);

        $arrs = [];
        $saparator = "---";
        $result02 =  $this->util_model->get_line_of_text_with_saparator_from_array($arrs, $saparator);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   "text1---text2---text3",
                                "",
                            ];

        $this->assertSame($result,$expectedResult);                        
    }

    //  return Array 
    public function test_get_property_names_of_one_object_as_array(){

        $obj            = new \stdClass();
        $obj->name      = "Wittaya";
        $obj->surname   = "Wijit";
        $result01 =  $this->util_model->get_property_names_of_one_object_as_array($object_name = $obj);

        $obj            = new \stdClass();
        $result02 =  $this->util_model->get_property_names_of_one_object_as_array($object_name = $obj);        

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   ["name","surname"],
                                [],
                            ];

        $this->assertSame($result,$expectedResult);
    }

    // return Array
    public function test_get_property_value_Of_many_objects_as_array(){

        $myObj1 = new \stdClass();
        $myObj1->my_id = "01";
        $myObj1->my_name = "Wittaya";

        $myObj2 = new \stdClass();
        $myObj2->my_id = "02";
        $myObj2->my_name = "Wichai";

        $myObj3 = new \stdClass();
        $myObj3->my_id = "03";
        $myObj3->my_name = "Sathit";

        $result01 =  $this->util_model->get_property_value_Of_many_objects_as_array(
                                        $array_of_objects =[$myObj1,$myObj2,$myObj3],
                                        $property = "my_id" );

        $result02 =  $this->util_model->get_property_value_Of_many_objects_as_array(
                                        $array_of_objects =[$myObj1,$myObj2,$myObj3],
                                        $property = "my_name" );

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   ["01","02","03"] ,
                                ["Wittaya","Wichai","Sathit"]
                            ];

        $this->assertSame($result,$expectedResult);

    }
    
    public function test_get_property_values_of_one_object_as_array(){
        $obj            = new \stdClass();
        $obj->name      = "Wittaya";
        $obj->surname   = "Wijit";
        $result01 =  $this->util_model->get_property_values_of_one_object_as_array($object_name = $obj);

        $obj            = new \stdClass();
        $result02 =  $this->util_model->get_property_values_of_one_object_as_array($object_name = $obj);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   ["Wittaya","Wijit"],
                                [],
                            ];
        $this->assertSame($result,$expectedResult);                            

    }

    // Return array of ojbect
    public function test_sort_array_of_object_by_the_property(){

        $user1          = new \stdClass();
        $user1->id      = 11;
        $user1->name    = "Wittaya";
        $user1->age     = 45;

        $user2          = new \stdClass();
        $user2->id      = 12;
        $user2->name    = "Sawitree";
        $user2->age     = 42;

        $user3          = new \stdClass();
        $user3->id      = 13;
        $user3->name    = "Somrudee";
        $user3->age     = 30;

        $objects = [$user1, $user2, $user3];

        $result01 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "id", 
                                $order_by="asc"
                            );

        $result02 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "id", 
                                $order_by="desc"
                            );

        $result03 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "age", 
                                $order_by="asc"
                            );                            

        $result04 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = [],     
                                $sorted_property = "", 
                                $order_by=""
                            );                            


        $result         =   [   [$result01[0]->id, $result01[1]->id,$result01[2]->id],
                                [$result02[0]->id, $result02[1]->id,$result02[2]->id],
                                [$result03[0]->id, $result03[1]->id,$result03[2]->id],
                                $result04,
                            ];

        $expectedResult =   [   [11, 12, 13],
                                [13, 12, 11],
                                [13, 12, 11],
                                [],
                            ];

        $this->assertSame($result,$expectedResult);

    }

    // Return text
    public function test_add_leading_zero_to_number(){

        $result1 =  $this->util_model->add_leading_zero_to_number( 
                                $text = 200, 
                                $num_required_digit = 1);
        $result2 =  $this->util_model->add_leading_zero_to_number( 
                                $text = 200,
                                $num_required_digit = 3);
        $result3 =  $this->util_model->add_leading_zero_to_number(
                                $text = 200, 
                                $num_required_digit = 4);
        $result4 =  $this->util_model->add_leading_zero_to_number( 
                                $text = 200, 
                                $num_required_digit = 6);

        $result         =   [
                                $result1,
                                $result2,
                                $result3,
                                $result4,
                            ];

        $expectedResult =   [   
                                "200",
                                "200",
                                "0200",
                                "000200",
                            ];

        $this->assertSame($result,$expectedResult);

    }

    //return array of pair values
    function test_separate_array_to_pair_value(){


        $origin_arr = [];
        $result1 = $this->util_model->separate_array_to_pair_value($origin_arr);

        $origin_arr = [ "one", "two", "three", "four"];
        $result2 = $this->util_model->separate_array_to_pair_value($origin_arr);        

        $origin_arr = [ "one", "two", "three"];
        $result3 = $this->util_model->separate_array_to_pair_value($origin_arr);        

        $result         =   [
                                $result1,
                                $result2,
                                $result3,
                            ];

        $expectedResult =   [   
                                [],
                                [ ["one","two"], ["three","four"] ],
                                [ ["one","two"], ["three", false] ],
                            ];

        $this->assertSame($result,$expectedResult);

    }

    // Return Array Of Object
    public function test_get_object_from_arr_object_that_match_property_condition(){

        $util_model = new UtilModel();

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->name = "Arun";         

        $arr_student = [$student1, $student2, $student3];
            
        // "=="
        $result01 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = [],
                                    $property_name = "id",
                                    $text_to_compare = 2,
                                    $operator = "=="
                                );

        $result02 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = 2,
                                    $operator = "=="
                                );

        $result03 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2", // It's OK to use 2 or "2"
                                    $operator = "=="
                                );

        $result04 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "name",
                                    $text_to_compare = "Arun",
                                    $operator = "=="
                                );

        // ">"
        $result05 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2",
                                    $operator = ">"
                                );                                

        // ">="
        $result06 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2",
                                    $operator = ">="
                                );                                                                
        // "<"
        $result07 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2",
                                    $operator = "<"
                                );                                                                
        // "<="
        $result08 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2",
                                    $operator = "<="
                                );                                                                
        // "!="
        $result09 = $util_model->get_object_from_arr_object_that_match_property_condition(
                                    $origin_arr_object = $arr_student,
                                    $property_name = "id",
                                    $text_to_compare = "2",
                                    $operator = "!="
                                );                                                                

        $result         =   [   // "=="
                                $result01,
                                $result02[0]->name,
                                $result03[0]->name,
                                $result04[0]->name,
                                // ">"
                                $result05[0]->name,
                                // ">="
                                $result06[0]->name,
                                count($result06),
                                // "<"
                                $result07[0]->name,
                                count($result07),
                                // "<="
                                $result08[0]->name,
                                count($result08),
                                // "!="
                                $result09[0]->name,
                                count($result09),

                            ];

        $expectedResult =   [               // "=="
                                [],
                                "Wicha",
                                "Wicha",
                                "Arun",
                                            // ">"
                                "Arun",
                                            // ">="
                                "Wicha",
                                2,
                                            // "<"
                                "Wittaya",
                                1,
                                            // "<="
                                "Wittaya",
                                2,
                                            // "!="
                                "Wittaya",
                                2,
                            ];

        $this->assertSame($result,$expectedResult);
                
    }

    // return float or zero
    public function test_get_average_property_of_arr_object(){

        $result1 = $this->util_model->get_average_property_of_arr_object(
            $arr_object = [], 
            $property = "age");

    /********************************************* */
        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";
        $student1->age = 30;

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->age = 31;

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->age = 32;

        $arr_student = [ $student1, $student2, $student3];        

        $result2 = $this->util_model->get_average_property_of_arr_object(
                        $arr_object = $arr_student, 
                        $property = "age");

    /********************************************* */                        
        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";
        $student1->age = "";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->age = 31;

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->age = 32;
        
        $arr_student = [ $student1, $student2, $student3];

        $result3 = $this->util_model->get_average_property_of_arr_object(
                        $arr_object = $arr_student, 
                        $property = "age");

    /**********************************************/

        $result         =  [
                                $result1,
                                (int) $result2,
                                (int) $result3,
                            ];

        $expectedResult =   [   
                                [],
                                31,
                                21,
                            ];

        $this->assertSame($result,$expectedResult);
    }

    // return float or zero
    public function test_get_sum_property_of_arr_object(){
        
        $result1 = $this->util_model->get_sum_property_of_arr_object( 
                            $arr_object = [], 
                            $property = "age"
                        );
    /**********************************************/        

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";
        $student1->age = 30;

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->age = 31;

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->age = 32;

        $arr_student = [ $student1, $student2, $student3];            
        
        $result2 = $this->util_model->get_sum_property_of_arr_object( 
                                $arr_object = $arr_student, 
                                $property = "age"
                            );

        /**********************************************/

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";
        $student1->age = "";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->age = 31;

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->age = 32;

        $arr_student = [ $student1, $student2, $student3];            
        
        $result3 = $this->util_model->get_sum_property_of_arr_object( 
                                $arr_object = $arr_student, 
                                $property = "age"
                            );

        /**********************************************/        
        $result         =   [
                                $result1,
                                (int) $result2,
                                (int) $result3,
                            ];

        $expectedResult =   [   
                                [],
                                93,
                                63

                            ];

        $this->assertSame($result,$expectedResult);                    
    }

    // return array_of_text
    public function test_get_line_of_text_from_array (){

        // Blank text array
        $arr_text = [];
        $result1 = $this->util_model->get_line_of_text_from_array ($arr_text, $saparator = "\t");

        // Blank sapator
        $arr_text = [ "text1", "text2", "text3"];
        $result2 = $this->util_model->get_line_of_text_from_array ($arr_text, $saparator = "");

        // with parameters
        $arr_text = [ "text1", "text2", "text3"];
        $result3 = $this->util_model->get_line_of_text_from_array ($arr_text, $saparator = ",");

        // with parameters
        $arr_text = [ "text1", "text2", "text3"];
        $result4 = $this->util_model->get_line_of_text_from_array ($arr_text, $saparator = "\t");        

        $result         =   [
                                $result1,
                                $result2,
                                $result3,
                                $result4,
                            ];

        $expectedResult =   [   
                                "",
                                "",
                                "text1,text2,text3",
                                "text1\ttext2\ttext3"

                            ];
        $this->assertSame($result,$expectedResult);                    

    }

    // return text
    public function test_get_text_data_from_array_of_object(){

        $result1 = $this->util_model->get_text_data_from_array_of_object(
                                    [],
                                    "xxx"
                                );    

        $result2 = $this->util_model->get_text_data_from_array_of_object(
                                    "xxx",
                                    []
                                );        
        
        // complete data
        $student1               = new \stdClass;
        $student1->firstname    = "Wittaya";
        $student1->lastname     = "Wijit";

        $student2               = new \stdClass;
        $student2->firstname    = "Winai";
        $student2->lastname     = "Meechai";        

        $arr_object = [$student1 , $student2];
        $arr_column = [ "firstname","lastname"];
        
        $result3 = $this->util_model->get_text_data_from_array_of_object(
                                    $arr_object,
                                    $arr_column
                                ); 

        // with blank data
        $student1               = new \stdClass;
        $student1->firstname    = "Wittaya";
        $student1->lastname     = "Wijit";

        $student2               = new \stdClass;
        $student2->firstname    = "Winai";
        $student2->lastname     = "";        

        $arr_object = [$student1 , $student2];
        $arr_column = [ "firstname","lastname"];
        
        $result4 = $this->util_model->get_text_data_from_array_of_object(
                                    $arr_object,
                                    $arr_column
                                ); 

        $result         =   [
                                $result1,
                                $result2,
                                $result3,
                                $result4,
                            ];
        $expectedResult =   [   
                                "",
                                "",
                                "Wittaya\tWijit\nWinai\tMeechai",
                                "Wittaya\tWijit\nWinai\tNULL",
                            ];
        $this->assertSame($result,$expectedResult);
    }

    // return array
    public function test_fill_null_in_array(){
        
        $result1 = $this->util_model->fill_null_in_array( []);
        $result2 = $this->util_model->fill_null_in_array( 
                                [ "one", "two", "" ]
                            );
        $result3 = $this->util_model->fill_null_in_array( 
                                [ "firstname"=>"Wittay", "lastname"=>"" ]
                            );

        $result         =   [
                                $result1,
                                $result2,
                                $result3
                            ];
        $expectedResult =   [   
                                [],
                                [ "one", "two", null ],
                                [ "firstname"=>"Wittay", "lastname"=> null ]
                            ];
        $this->assertSame($result,$expectedResult);
    }

    // return array of array
    public function test_saparate_array_to_row(){

        $arr_source =   [ "01", "02", "03", "04" ];
        $result1 = $this->util_model->saparate_array_to_row(
                                $arr_source,
                                $num_row = 2,
                                $num_per_row = 2);
        $arr_source =   [ ];
        $result2 = $this->util_model->saparate_array_to_row(
                                $arr_source,
                                $num_row = 2,
                                $num_per_row = 2);

        $arr_source =   [ "01", "02", "03", "04" ];
        $result3 = $this->util_model->saparate_array_to_row(
                                $arr_source,
                                $num_row = 1,
                                $num_per_row = 2);

        $result         =   [
                                $result1,
                                $result2,
                                $result3,
                            ];
        $expectedResult =   [   
                                [   
                                    ["01","02"],
                                    ["03","04"]
                                ],
                                
                                [ ],
                                
                                [   
                                    ["01","02"],
                                ],

                            ];

        $this->assertSame($result,$expectedResult);
    }

    // return object or false
    public function test_get_object_model_from_table_name(){

        $result1 = $this->util_model->get_object_model_from_table_name($table_name = "user");
        $result2 = $this->util_model->get_object_model_from_table_name($table_name = "");

        $result         =   [
                                is_object($result1),
                                $result2,
                            ];
        $expectedResult =   [   
                                true,
                                false,
                            ];
        $this->assertSame($result,$expectedResult);
    }

    // return sanitized text
    public function test_sanitize_text_to_export(){

        $result1 = $this->util_model->sanitize_text_to_export($text = "xxx\nyyy");
        $result2 = $this->util_model->sanitize_text_to_export($text = "xxx\r\nyyy");

        $result         =   [
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [   
                                "xxx[newline]yyy",
                                "xxx[newline]yyy",
                            ];
        $this->assertSame($result,$expectedResult);
    }

    // return sanitized text
    public function test_sanitize_text_to_import(){

        $result1 = $this->util_model->sanitize_text_to_import($text = "xxx[newline]yyy");

        $result         =   [
                                $result1,
                            ];
        $expectedResult =   [   
                                "xxx\r\nyyy",
                            ];
        $this->assertSame($result,$expectedResult);
    }

    // return random number or fale
    public function test_get_random_number(){

        $result1 = $this->util_model->get_random_number($num_digit = 1);
        $result2 = $this->util_model->get_random_number($num_digit = 2);
        $result3 = $this->util_model->get_random_number($num_digit = 6);
        $result4 = $this->util_model->get_random_number($num_digit = 7);
        $result5 = $this->util_model->get_random_number($num_digit = 0);

        $result         =   [
                                strlen($result1),
                                strlen($result2),
                                strlen($result3),
                                $result4,
                                $result5,
                            ];
        $expectedResult =   [   
                                1,
                                2,
                                6,
                                false,
                                false,
                            ];
        $this->assertSame($result,$expectedResult);
    }



}