<?php

namespace App\Controllers;

use App\Models\UtilModel;

class MyController extends BaseController {

	var $util_model;

	public function __construct(){

		$this->util_model = new UtilModel;
	}    

	public function _view($filename,$data){

		$data["controller_name"] = $this->_get_controller_name();

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
