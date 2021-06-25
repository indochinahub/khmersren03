<?php

namespace App\Controllers;

use App\Models\UtilModel;

class Main extends MyController
{


	public function index()	{
		
		$this->_view("index",[]);

	}



}

