<?php

namespace Tinque\SGDFIntranetSDK;

use Tinque\SGDFIntranetSDK\User\RetrieveInformations;

use Goutte\Client As GoutteClient;

class SGDFIntranetUser {
	
	private $mLogin;
	private $mPassword;

	private $isConnected = false;

	private $areCredentialsValid = false;	
	private $mCredentialsError = '';

	//Goutte client
	private $mClientGoutte;

	//retriev information
	private $mRetrieve;
	
	
	function __construct($login,$password)
	{
		
		$this->mLogin = $login;
		$this->mPassword = $password;

		$this->mClientGoutte = new GoutteClient();

		$this->mRetrieve = new RetrieveInformations($login,$password);
		
	}

	private function connect()
	{
		$crawler = $this->mClientGoutte->request('GET', 'https://intranet.sgdf.fr');


                $form = $crawler->selectButton('Se connecter')->form();

                $crawler = $this->mClientGoutte->submit($form, array('ctl00$MainContent$login' => $this->mLogin, 'ctl00$MainContent$password' => $this->mPassword));
                if($crawler->filter('html:contains("Erreur")')->count()>0)
                {
                	$this->isConnected = false;
			$this->areCredentialsValid = false;
			$this->mCredentialsError = $crawler->filter('.erreur')->text();
		}
                else
                {
                
			$this->isConnected = true;
                        $this->areCredentialsValid = true;
		}

	}
	public function getLogin() {
		return $this->mLogin;
	}
	
	
	public function areCredentialsValid()
	{
		if(!$this->isConnected)
		{
			$this->connect();
		}
		return $this->areCredentialsValid;
	}

	public function isConnected()
	{

		if(!$this->isConnected)
                {
                        $this->connect();
                }
                return $this->isConnected;

	}
	public function getCredentialsError()
	{
		return $this->mCredentialsError;

	}
	
}
