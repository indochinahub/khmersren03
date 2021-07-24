<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UtilModel;

class Test extends MyController
{

	public function testPaginationP()	{

		$user_model = new UserModel;
		$util_model = new UtilModel;

		$arr_user = $user_model->get_all_row();
		$arr_user = array_slice( $arr_user, 0,100);


		if( ! ($page = $this->request->getGet('page')) ){
			$page = 1;
		}

		$pager = service("pager");
		$perPage = 20;
		$total = count($arr_user);
		$pagination_link  = $pager->makeLinks( $page , $perPage , $total);
		$start_key = $util_model->get_start_item_for_pagination( $page, $perPage);

		$arr_user = array_slice( $arr_user, $start_key,$perPage);

		echo $pagination_link;
		echo "<hr>";
		
		foreach( $arr_user as $user ){
			echo "User Id".$user->user_id."<br>";
		}
		
		
		
	}

}

