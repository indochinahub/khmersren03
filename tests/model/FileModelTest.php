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

        $result1 = $this->file_model->create_file( ASSETPATH."/test/001create_file/test.txt" );

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

    /*
        $dir_name = FCPATH."assets/test/007write_to_file";
        $file_name = "write_text.txt";
        $text = "Hello, Everybody! ";

        // Create Blank File
        $my_file = fopen( $dir_name."/".$file_name, 'w') ;
        fclose($my_file);

        $result01 = $this->file_model->write_to_file($dir_name,$file_name, $text);

        $dir_name = FCPATH."assets/test/007write_to_file";
        $file_name = "kkkkkk"; //There is no file.
        $text = "Hello, Everybody! ";  
        $result02 = $this->file_model->write_to_file($dir_name,$file_name, $text);

        $result             =   [   $result01,
                                    $result02,
                                ];
                        
        $expectedResult     =   [   TRUE,
                                    FALSE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);
    
    

    */

    
}