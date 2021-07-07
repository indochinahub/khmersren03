<?php

namespace App\Controllers;

use \App\Models\UserModel;

class User extends MyController
{
	public function login()	{
		
		$user_model = new UserModel();

		$validattion_rules = 	[	'username' => 'required',
									'password' => 'required'
								];

		// Set the task
		$data = [];
		if( ($this->request->getMethod() === "post") && ($this->validate($validattion_rules)) ){
			$data["task"] = "validate_user";
			
		}elseif( $this->request->getMethod() === "post" ){
			$data["username_error"] = $this->validator->getError('username');
			$data["password_error"] = $this->validator->getError('password');
			$data["task"] = "form_error";

		}else{
			$data["task"] = "form_blank";

		}

		// Do the task
		if($data["task"] === "form_blank"){
			$data["username"]  = "";

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);			

		}elseif($data["task"] === "form_error"){

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);		

		}elseif($data["task"] === "validate_user"){
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			if( $user = $user_model->get_validated_user($username, $password)){

				$this->session->set('id', $user->user_id);
				die("found user");

			}else{
				die("invalid username and password");
			}
			
		}
	}

	

	public function test(){

	}

}

