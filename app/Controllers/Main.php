<?php

namespace App\Controllers;

use App\Models\UtilModel;

class Main extends MyController
{
	var $util_model;

	public function __construct(){

		$this->util_model = new UtilModel;
	}

	public function index()	{
		
		$this->_view("index",[]);

	}



}

