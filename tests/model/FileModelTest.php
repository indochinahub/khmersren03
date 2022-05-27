<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class FileModelTest extends CIUnitTestCase
{

    var $file_model;


    public function setUp(): void
    {
        $this->file_model = new FileModel;

        if(file_exists(ASSETPATH."/test/001create_file/test.txt")){
            unlink(ASSETPATH."/test/001create_file/test.txt" );
        }
    }        

    //create_file($fullpathname)
    public function test_create_file(){

        $result1 = $this->file_model->create_file( ASSETPATH."test/001create_file/test.txt" );

        $result             =   [ $result1 ];
        $expectedResult     =   [ true ];

        $this->assertSame($result,$expectedResult);

    }

    // return true or false
    public function test_write_to_file( ){

        $result1    =   $this->file_model->write_to_file( 
                                ASSETPATH."test/002write_to_file/write_text.txt" , 
                                $text = "Hello"
                            );

        // there is no xxxx.txt
        $result2    =   $this->file_model->write_to_file( 
                                ASSETPATH."test/002write_to_file/xxxx.txt" , 
                                $text = "Hello"
                            );


        $result             =   [ $result1, $result2 ];
        $expectedResult     =   [ true, false ];

        $this->assertSame($result,$expectedResult);

    }

    // return array of column and array of row
    public function test_get_data_from_export_file(){

        $result1 = $this->file_model->get_data_from_export_file( 
                                ASSETPATH."test/03import_text_file_to_card/import1.txt" 
                            );

        // There are some blank value in the file import2.txt
        $result2 = $this->file_model->get_data_from_export_file( 
                                ASSETPATH."test/03import_text_file_to_card/import2.txt" 
                            );

        $result             =   [   
                                    $result1->arr_column,
                                    $result1->table_name,

                                    $result1->arr_row[0]->firstname,
                                    $result1->arr_row[0]->lastname,
                                    $result1->arr_row[0]->number,

                                    $result1->arr_row[1]->firstname,
                                    $result1->arr_row[1]->lastname,
                                    $result1->arr_row[1]->number,  
                                    
                                    $result2->arr_row[0]->firstname,
                                    $result2->arr_row[0]->lastname,
                                    $result2->arr_row[0]->number,
                                    

                                ];
        $expectedResult     =   [ 
                                    ["firstname", "lastname", "number"],
                                    "student",

                                    "Wittaya",
                                    "Wijit",
                                    "01",

                                    "Suchat",
                                    "Sukjai",
                                    "02",

                                    "Wittaya",
                                    "NULL",
                                    "01",

                                ];

        $this->assertSame($result,$expectedResult);        
    }

    // return true
    public function test_delete_file(){

        $full_pathname = ASSETPATH."test/04delete_file/file_to_delete.txt";

        // Create Blank File
        $my_file = fopen( $full_pathname, 'w' ) ;
        fclose($my_file);

        $result1 = $this->file_model->delete_file( $full_pathname );

        $result             =   [   
                                    $result1
                                ];
        $expectedResult     =   [ 
                                    true,
                                ];

        $this->assertSame($result,$expectedResult);               
    }

    // return true
    public function test_resize_image(){
 
        $old_pathname = ASSETPATH."test/file_to_resize.jpg";
        $new_pathname = ASSETPATH."test/05resize_file/file_to_resize.jpg";
        copy($old_pathname, $new_pathname);

        $result1 = $this->file_model->resize_image($new_pathname, $size = 800);

        $result             =   [   
                                    $result1,
                                ];
        $expectedResult     =   [ 
                                    true,
                                ];

        $this->assertSame($result,$expectedResult);      
        
        unlink($new_pathname);

    }    
}