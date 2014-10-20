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
	private $mType = -1;
	private $mFinFonction = -1;
	private $mCodePostal = -1;
	private $mVille =  -1;
	private $mFinAdhesion;
	
	
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
	public function getType() {
		return $this->mType;
	}
	public function setType($mType) {
		$this->mType = $mType;
		return $this;
	}
	public function getFinFonction() {
		return $this->mFinFonction;
	}
	public function setFinFonction($mFinFonction) {
		$this->mFinFonction = $mFinFonction;
		return $this;
	}
	public function getCodePostal() {
		return $this->mCodePostal;
	}
	public function setCodePostal($mCodePostal) {
		$this->mCodePostal = $mCodePostal;
		return $this;
	}
	public function getVille() {
		return $this->mVille;
	}
	public function setVille($mVille) {
		$this->mVille = $mVille;
		return $this;
	}
	public function getFinAdhesion() {
		return $this->mFinAdhesion;
	}
	public function setFinAdhesion($mFinAdhesion) {
		$this->mFinAdhesion = $mFinAdhesion;
		return $this;
	}
	
}
