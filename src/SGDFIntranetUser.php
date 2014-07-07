<?php

namespace Tinque\SDGFIntranetSDK;

use Tinque\SDGFIntranetSDK\User\RetrieveInformations As RetrieveInformations;

class SGDFIntranetUser {
	
	private $mRetrieve;
	
	
	public function ___construct($login,$password)
	{
		
		$this->mRetrieve = new RetrieveInformations($login,$password);
		
	}
	
	public function getLogin() {
		return $this->mRetrieve->getLogin();
	}
	
	
	public function areCredentialsValid()
	{
		return $this->mRetrieve->areCredentialsValid();
	}
	
}