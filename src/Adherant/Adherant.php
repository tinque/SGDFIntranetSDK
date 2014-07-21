<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK\Adherant;

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;
use Tinque\SGDFIntranetSDK\Adherant\AdherantInformations;

class Adherant {
	
	private $mNomPrenom = -1;
	private $mCodeAdherant = - 1;
	private $mCodeFonction = - 1;
	
	
	function __construct()
	{
		//void
	}
	
	/**
	 * Retourne les informations sur l'adherant
	 * @param SGDFIntranetUser $user
	 * @return \Tinque\SGDFIntranetSDK\Adherant\AdherantInformations
	 */
	public function createAdherantInformations(SGDFIntranetUser &$user)
	{
		return new AdherantInformations($user, $this->mCodeAdherant);
	}
	
	
	
	/*
	 * Getters 
	 */
	
	public function getNomPrenom()
	{
		return $this->mNomPrenom;
	}
	
	public function getCodeAdherant()
	{
		return $this->mCodeAdherant;
	}
	
	public function getCodeFonction()
	{
		return $this->mCodeFonction;
	}
	
	/*
	 * Setters
	 */
	
	public function setNomPrenom($nomprenom)
	{
		$this->mNomPrenom = $nomprenom;
		return $this;
	}
	
	public function setCodeFonction($codefonction)
	{
		$this->mCodeFonction = $codefonction;
		return $this;
	}
	
	public function setCodeAdherant($codeadherant)
	{
		$this->mCodeAdherant = $codeadherant;
		return $this;
	}
}
