<?php

namespace App\Controllers;

class Test extends MyController
{


	public function index()	{
		
        helper(["custom"]);
		
        echo get_name();

	}

}

