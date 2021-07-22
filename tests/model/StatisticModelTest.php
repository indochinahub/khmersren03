<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class StatisticModel extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->user_model = new UserModel();

    }    

    
}