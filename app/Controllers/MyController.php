<?php

namespace App\Controllers;

use App\Models\UtilModel;
use App\Models\UserModel;

class MyController extends BaseController {

	var $util_model;
	var $validation;
	var $request;
	var $session;
	var $uid; 

  	public function __construct(){

		$this->util_model = new UtilModel;
		$this->request = service('request');
		$this->session = service('session');
 
		$this->uid = 0;
		if( $uid = $this->session->get("uid") ){
			$this->uid = (int) $uid;
		}

	}    

	public function _view($filename,$data){

		// Pass some vars to View
			$data["uid"] = $this->uid;

		// Controller Name
		$data["controller_name"] = $this->_get_controller_name();
		$data["user"] = $this->_get_loggedin_user();

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





}
