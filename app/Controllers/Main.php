<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PaginationModel;

class Main extends MyController
{


	public function index(){

		$data["page_title"] = 	"Title "; 
		$data["page_link"] 	= 	[   "กลับ",
									$this->_get_backlink()
							   ];
		$this->_view("index",$data);             

	}
}

