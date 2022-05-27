<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class PaginationModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->pagination_model = new PaginationModel;

    }   
    
    // return Pagination Links and array of object
    public function test_get_pagination(){

        $arr_row    =  [   "a", "b", "c",
                            "d", "e", "f",
                            "g", "h", "i",
                            "j"
                        ];

        $result1    = $this->pagination_model->get_pagination( $arr_row, $current_page = 1, $per_page = 3); 
        $result2    = $this->pagination_model->get_pagination( $arr_row, $current_page = 2, $per_page = 3); 

        $result         =   [ 
                                strlen($result1->link) > 0,
                                $result1->arr_row,
                                $result2->arr_row,
                            ];

        $expectedResult =   [ 
                                true,
                                ["a", "b", "c"],
                                ["d", "e", "f"],
                            ];

        $this->assertSame($expectedResult, $result);           

    }

    
}