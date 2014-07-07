<?php

namespace Tinque\SDGFIntranetSDK\User;

class RetrieveInformations {
	
	private $mLogin;
	private $mPassword;
	
	
	public function ___construct($login,$password)
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