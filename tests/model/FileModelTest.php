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
        $this->assetPath = "f:/xampp/htdocs/khmersren03/asset";

        if(file_exists($this->assetPath."/test/001create_file/test.txt")){
            unlink( $this->assetPath."/test/001create_file/test.txt" );
        }


    }        

    //create_file($fullpathname)
    public function test_create_file(){

        $result1 = $this->file_model->create_file( $this->assetPath."/test/001create_file/test.txt" );

        $result             =   [ $result1 ];
        $expectedResult     =   [ true ];

        $this->assertSame($result,$expectedResult);

    }


    
}