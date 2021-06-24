<?php

namespace App\Controllers;

use App\Models\UtilModel;

class Main extends BaseController
{
	public function index()	{
		
		/*
		$name = get_class($this);
		var_dump($name);
		echo "<hr>";

		var_dump($name);
		echo "<hr>";

		$user_model =  new \App\Models\UserModel;
		echo $user_model->get_num_user();
		*/

		echo view('Main/index');

	}


}

