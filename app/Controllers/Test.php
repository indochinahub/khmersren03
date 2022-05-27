<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UtilModel;
use App\Models\PaginationModel;

class Test extends MyController
{

	public function index(){
		/******************************* */
		// Pagination
		/******************************* */

		$pager = service("pager");
		$perPage = 5;
		$total = 33;
		$data["pagination"]  = $pager->makeLinks( $page = 3 , $perPage , $total);

		$this->_view("index",$data);
	}

	public function pagination()	{

		$user_model = new UserModel;
		$util_model = new UtilModel;
		$pagination_model = new PaginationModel;

		$arr_user = $user_model->get_all_row();
		$arr_user = array_slice( $arr_user, 0,100);

		if( ! ($page = $this->request->getGet('page')) ){
			$page = 1;
		}
		$pagination = $pagination_model->get_pagination( 
								$arr_row = $arr_user, 
								$current_page = $page , 
								$per_page = 3
							);
		
		echo $pagination->link;
		echo "<hr>";
		
		$arr_user = $pagination->arr_row;
		
		foreach( $arr_user as $user ){
			echo "User Id".$user->user_id."<br>";
		}		
		
	}

	public function mail(){

		$email = \Config\Services::email();

		$email->setFrom('indochinahub@gmail.com', 'Wittaya  Wijit');
		$email->setTo('indochinahub@gmail.com');
		//$email->setCC('another@another-example.com');
		//$email->setBCC('them@their-example.com');
		
		$email->setSubject('Hello Wittaya');
		$email->setMessage('Testing the email class.');
		
		$email->send();



	}

}

