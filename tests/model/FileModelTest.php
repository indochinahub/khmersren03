<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class FileModelTest extends CIUnitTestCase
{

    var $assetPath;
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


    
}