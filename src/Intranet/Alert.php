<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK\Intranet;


class Alert {
	
	private $mTitre = -1;
	private $mTexte = -1; 
	
	function __construct()
	{
		
	}
	
	
	
	/*
	 * Getters 
	 */
	
	public function getTitre()
	{
		return $this->mTitre;
	}
	
	public function getTexte()
	{
		return $this->mTexte;
	}
	
		
	
	/*
	 * Setters
	 */
	
	public function setTitre($titre)
	{
		$this->mTitre = $titre;
		return $this;
	}
	
	public function setTexte($texte)
	{
		$this->mTexte = $texte;
		return $this;
	}
}