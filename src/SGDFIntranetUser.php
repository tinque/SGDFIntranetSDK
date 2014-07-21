<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice 
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK;

use Goutte\Client as GoutteClient;

use Tinque\SGDFIntranetSDK\User\ProfileInformations;
use Tinque\SGDFIntranetSDK\Structure\StructureInformations;
use Tinque\SGDFIntranetSDK\User\UserStructure;

/**
 * Classe pour la création d'un utilisateur de l'intranet SGDF
 * 
 * @author Tinque
 * @copyright Tinque
 * @license Beerware
 *
 */

class SGDFIntranetUser {
	
	
	private $mLogin;
	private $mPassword;
	private $isConnected = false;
	private $areCredentialsValid = false;
	private $mCredentialsError = '';
	
	// Goutte client
	private $mClientGoutte;
	
	
	/**
	 * constructeur
	 * @param string $login
	 * @param string $password
	 */
	
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
	
	/**
	 * 
	 * @return string login de l'utilisateur
	 */
	
	public function getLogin() {
		return $this->mLogin;
	}
	
	/**
	 * @return boolean Vrai si les authentifiants sont valides
	 */
	public function areCredentialsValid() {
		if (! $this->isConnected) {
			$this->connect ();
		}
		return $this->areCredentialsValid;
	}
	
	/**
	 * 
	 * @return boolean est ce que l'utilisateur est connecté
	 * TODO : Refaire cette fonction 
	 * 
	 */
	
	public function isConnected() {
		if (! $this->isConnected) {
			$this->connect ();
		}
		return $this->isConnected;
	}
	
	/**
	 * 
	 * @return string retourne l'erreur d'authentification
	 */
	
	public function getCredentialsError() {
		return $this->mCredentialsError;
	}
	
	/**
	 * 
	 * @return \Goutte\Client retourne le crawler
	 */
	public function getClientGoutte() {
		return $this->mClientGoutte;
	}
	
	/**
	 * 
	 * @return boolean true si la connection est encore bonne
	 */
	
	public function checkConnection() {
		
		
		
		$crawler = $this->mClientGoutte->request ( 'GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/securite/ChangerMotDePasse.aspx' );
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
	
	/**
	 * Retourne un objet contenant les informations de l'utilisateur courrant
	 * @return \Tinque\SGDFIntranetSDK\User\ProfileInformations Informations sur le profil utilisateur
	 */
	public function createProfileInformations()
	{
		return new ProfileInformations($this);
	}
	
	/**
	 * Retourne la structure avec le code donné ou la structure de l'adhérant
	 * @param string $codeStructure
	 * @return \Tinque\SGDFIntranetSDK\Structure\StructureInformations
	 */
	public function createStructureInformations($codeStructure = null)
	{
		if(!isset($codeStructure))
		{
			return new StructureInformations($this, $this->createProfileInformations()->getCodeStructure());
		}
		else
		{
			return new StructureInformations($this, $codeStructure);
		}
		
	}
	
	/**
	 * Retourne un objet contenant les informations de la structure de l'utilisateur courant
	 * @return \Tinque\SGDFIntranetSDK\User\UserStructure Informations sur la strcuture de l'utilisateur
	 */
	public function createUserStructure()
	{
		return new UserStructure($this);
	}
	
	
}
