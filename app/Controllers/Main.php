<?php

namespace App\Controllers;

class Main extends MyController
{


	public function index()	{
		
		$this->_view("index",[]);

	}

	public function confirm(){
		
		$data    =  [   "page_title"=>"ยืนยันการชุดบัตรคำ",
						"what_happened"=>"นี่คือสิ่งที่คุณได้ดำเนินการ ",
						"what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
						"btnText_toConfirm" => "ยืนยัน",
						"btnLink_toConfirm" => base_url(),
						"btnText_toCancle" => "ยกเลิก",
						"btnLink_toCancle" => base_url(),
					];  		
		$this->_confirm($data);

	}


}

