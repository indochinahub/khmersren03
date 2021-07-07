<?php

namespace App\Controllers;

use App\Models\UtilModel;

class MyController extends BaseController {

	var $util_model;
	var $validation;
	var $request;
	var $session;

  	public function __construct(){
		$this->util_model = new UtilModel;
		$this->request = service('request');
		$this->session = service('session');
		
	}    

	public function _view($filename,$data){

		// Controller Name
		$data["controller_name"] = $this->_get_controller_name();

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
		echo view( $this->_get_controller_name().'/'.$filename,$data);
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





}
