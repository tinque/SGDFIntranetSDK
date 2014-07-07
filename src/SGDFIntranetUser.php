<?php

namespace Tinque\SDGFIntranetSDK;

class SGDFIntranetUser {
	
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
	
}