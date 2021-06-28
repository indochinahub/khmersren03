<?php

namespace App\Controllers;

class User extends MyController
{
	public function login()	{

		// Set the task
		$data = [];
		if( $this->request->getMethod() === "post" ){

			$validattion_rules = 	[		'username' => 'required',
											'password' => 'required'
									];
			if( $this->validate($validattion_rules) ){
				$data["task"] = "update_data";

			}else{

				$data["username_error"] = $this->validator->getError('username');
				$data["password_error"] = $this->validator->getError('password');
				$data["task"] = "form_error";
			}
		}else{
			$data["task"] = "form_blank";
		}

		// Do the task
		if( $data["task"] === "form_blank" ){

			$data["username"]  = "";

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);			

		}elseif( $data["task"] === "form_error" ){

			$data["page_title"] = 	"Login";
			$data["page_link"] 	= 	[	"Home",
										base_url()
									];		
			$this->_view("login",$data);			
		}
	}

	public function test(){

	}

}

