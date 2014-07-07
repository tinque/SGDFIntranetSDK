<?php

namespace Tinque\SDGFIntranetSDK;

use Tinque\SDGFIntranetSDK\User\RetrieveInformations;

class SGDFIntranetUser {
	
	private $mRetrieve;
	
	
	function __construct($login,$password)
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