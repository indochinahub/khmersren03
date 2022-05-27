<?php

namespace App\Models;
use App\Models\DatetimeModel;

class PaginationModel
{
    // return Pagination Links and array of object
    public function get_pagination( $arr_row, $current_page, $per_page){

		  $pager = service("pager");

      $pagination = new \stdClass;
		  $pagination->link = $pager->makeLinks( $current_page , $per_page , count($arr_row) );

      $start_key = ($current_page - 1) * $per_page;
      $pagination->arr_row = array_slice( $arr_row, $start_key, $per_page);

      return $pagination;
    }



}


