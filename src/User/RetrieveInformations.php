<?php

namespace Tinque\SDGFIntranetSDK\User;

class RetrieveInformations {
	
	private $mLogin;
	private $mPassword;
	
	
	function __construct($login,$password)
	{
		$this->mLogin =$login;
		$this->mPassword = $password;
	}
	
	
	public function getLogin() {
		return $this->mLogin;
	}
	
	
	public function areCredentialsValid()
	{
		return false;
	}
	
	
}