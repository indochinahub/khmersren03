<?php

namespace App\Controllers;

use App\Models\UtilModel;
use App\Models\UserModel;
use App\Models\DatetimeModel;
use App\Models\StatisticModel;
use App\Models\MessageModel;


class MyController extends BaseController {

	var $util_model;
	var $user_model;

	var $validation;
	var $request;
	var $session;
	var $uri;
	var $uid; 

  	public function __construct(){

		helper(["my"]);

		$this->util_model = new UtilModel;
		$this->user_model = new UserModel;

		$this->request = service('request');
		$this->session = service('session');
		$this->uri = service('uri');
		
		// Set User Id
		if( $uid = $this->session->get("uid") ){
			$this->uid = (int) $uid;
			setcookie('uid', $this->uid, time() + (86400 * 7), "/");
			$this->user_model->update_visit_time($this->uid);

		}elseif( isset($_COOKIE["uid"]) ){
			$this->uid = (int) $_COOKIE["uid"];
			$this->session->set('uid', $this->uid);

		}else{
			$this->uid = 0;
		}
		
		// Create Daily Statistic
		if( $user = $this->_get_loggedin_user()){
			$statistic_model = new StatisticModel;
			$statistic_model->create_daily_statistic($user->user_id, time());

		}
	}

	public function _view($filename,$data){
		$message_model = new MessageModel;

		// Pass some vars to View
			$data["uid"] = $this->uid;

		// Controller Name
		$data["controller_name"] = $this->_get_controller_name();

		// Pass user object
		if( $data["loggedin_user"] = $this->_get_loggedin_user() ){
			$data["user_avatar_url"] = $this->user_model->get_avarta_url($data["loggedin_user"]);
			$data["total_unread_message"] = $message_model->get_total_num_unread_message($data["loggedin_user"]->user_id);

		}else{  // get anonymous avatar
			$data["user_avatar_url"] = base_url(["asset","media","user_media","anonymous.jpg" ]);
			$data["num_unread_message"] = 0;

		}

		// Pass member object
		if( isset($data["member"] ) && ( $data["member"] !== false ) ){
			$data["member_avatar_url"] = $this->user_model->get_avarta_url($data["member"]);

		}else{ // get anonymous avatar
			$data["member"] = false;
			$data["member_avatar_url"] = base_url(["asset","media","user_media","anonymous.jpg" ]);

		}

		// Page Title 
		if( isset($data["page_title"]) && trim($data["page_title"])){
			$data["page_title"] = $data["page_title"];
		}else{
			$data["page_title"] = FALSE;
		}

		// Page Link
		if( isset($data["page_link"]) && (count($data["page_link"]) === 2) ){
			$data["page_link"] = $data["page_link"];
		}else{
			$data["page_link"] = FALSE;
		}

		// Show Views
		echo view('section/010head',$data);
		echo view('section/020sidebar',$data);
		echo view('section/030jumbotron',$data);
		echo view('section/040navbar',$data);
		echo view('section/050breadcrumb',$data);
		echo view('section/055waning.php',$data);

		if( $filename === "warn" ){
			echo view( 'section/210warn', $data);
		}elseif( $filename === "confirm" ){
			echo view( 'section/220confirm', $data);
		}else{
			echo view( $this->_get_controller_name().'/'.$filename,$data);
		}

		echo view('section/070noticebox',$data);
		echo view('section/080footer',$data);
		echo view('section/090javascript',$data);
	}

	public function _get_controller_name(){
		$router = service('router'); 
		$full_controller_name  = $router->controllerName(); 
		$controller_name = $this->util_model->get_class_from_fullname($full_controller_name);
		return $controller_name;
	}

	public function _warn($data){
		if  (   isset($data["page_title"]) && isset($data["what_happened"]) && isset($data["what_todo"])
                &&isset($data["btnText_toGo"]) && isset($data["btnLink_toGo"])
            ){
			$this->_view("warn",$data);
            
        }else{
            
            die("There is not enought data to show Error;");
        }  
	}

	public function _needLogin(){
		$data	= [     "page_title"=>"กรุณาเข้าสู่ระบบ",
						"what_happened"=>"หน้านี้สำหรับสมาชิกเท่านั้น",
						"what_todo" => "กรุณาเข้าสู่ระบบ โดยคลิ๊กที่ปุ่ม <bold>ไป</bold>",
						"btnText_toGo" => "ไป",
						"btnLink_toGo" => base_url(["User", "login"])
				];
		$this->_warn($data);
	}

	public function _needPrivilege(){
		$data	= [     "page_title"=>"คุณไม่มีสิทธิ์ดำเนินการ",
						"what_happened"=>"คุณไม่สิทธิืในการดำเนินการนี้",
						"what_todo" => "โดยคลิ๊กที่ปุ่ม <bold>กลับ</bold> เพื่อกลับไปหน้าที่แล้ว",
						"btnText_toGo" => "กลับ",
						"btnLink_toGo" => $this->_get_backlink()
				];
		$this->_warn($data);
	}

	public function _needToBeAdmin(){
		$data	= [     "page_title"=>"ต้องการสิทธิ์ผู้ดูแลระบบ",
						"what_happened"=>"หน้านี้สำหรับผู้ดูแลระบบเท่านั้น",
						"what_todo" => "กรุณาเข้าสู่ระบบ หรือใช้บัญชีที่มีสิทธิ์ <bold>ไป</bold>",
						"btnText_toGo" => "ไป",
						"btnLink_toGo" => base_url(["User", "login"])
				];
		$this->_warn($data);
	}

	public function _confirm($data){

        if  (   isset($data["page_title"]) && isset($data["what_happened"]) && isset($data["what_todo"])
                &&isset($data["btnText_toConfirm"]) && isset($data["btnLink_toConfirm"])
                &&isset($data["btnText_toCancle"]) && isset($data["btnLink_toCancle"])
            ){

				/*
				$data    =  [   "page_title"=>"ยืนยันการชุดบัตรคำ",
								"what_happened"=>"นี่คือสิ่งที่คุณได้ดำเนินการ ",
								"what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
								"btnText_toConfirm" => "ยืนยัน",
								"btnLink_toConfirm" => base_url(),
								"btnText_toCancle" => "ยกเลิก",
								"btnLink_toCancle" => base_url(),
							];  		
				*/

				$this->_view("confirm",$data);
            
        }else{

			die("There is not enought data to show Confirm;");

        }
	}

	public function _get_loggedin_user(){
		$user_model = new UserModel();

		if( $this->uid === 0  ){
			return false;
		}else{
			return $user_model->get_user_by_id($this->uid);
		}
	}

	public function _get_backlink(){

        if( isset( $_SERVER['HTTP_REFERER'] ) ){
            return $_SERVER['HTTP_REFERER'];
        }else{
            return base_url();
        }		
	}


}
