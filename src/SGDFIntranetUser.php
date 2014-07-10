<?php

/**
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice 
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK;

use Tinque\SGDFIntranetSDK\User\RetrieveInformations;
use \Serializable;
use Goutte\Client as GoutteClient;

class SGDFIntranetUser {
	private $mLogin;
	private $mPassword;
	private $isConnected = false;
	private $areCredentialsValid = false;
	private $mCredentialsError = '';
	
	// Goutte client
	private $mClientGoutte;
	function __construct($login, $password) {
		$this->mLogin = $login;
		$this->mPassword = $password;
		
		$this->mClientGoutte = new GoutteClient ();
	}
	private function connect() {
		$crawler = $this->mClientGoutte->request ( 'GET', 'https://intranet.sgdf.fr' );
		
		$form = $crawler->selectButton ( 'Se connecter' )->form ();
		
		$crawler = $this->mClientGoutte->submit ( $form, array (
				'ctl00$MainContent$login' => $this->mLogin,
				'ctl00$MainContent$password' => $this->mPassword 
		) );
		if ($crawler->filter ( 'html:contains("Erreur")' )->count () > 0) {
			$this->isConnected = false;
			$this->areCredentialsValid = false;
			$this->mCredentialsError = $crawler->filter ( '.erreur' )->text ();
		} else {
			
			$this->isConnected = true;
			$this->areCredentialsValid = true;
		}
	}
	public function getLogin() {
		return $this->mLogin;
	}
	public function areCredentialsValid() {
		if (! $this->isConnected) {
			$this->connect ();
		}
		return $this->areCredentialsValid;
	}
	public function isConnected() {
		if (! $this->isConnected) {
			$this->connect ();
		}
		return $this->isConnected;
	}
	public function getCredentialsError() {
		return $this->mCredentialsError;
	}
	public function getClientGoutte() {
		return $this->mClientGoutte;
	}
	public function checkConnection() {
		$crawler = $this->mClientGoutte->request ( 'GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/Accueil.aspx' );
		if ($crawler->filter ( 'html:contains("Identification")' )->count () > 0) {
			$this->isConnected = false;
		} else {
			$this->isConnected = true;
		}
		return $this->isConnected;
	}
	public function reConnect() {
		$this->connect ();
		if ($this->isConnected) {
			
			return true;
		} else {
			return false;
		}
	}
}
