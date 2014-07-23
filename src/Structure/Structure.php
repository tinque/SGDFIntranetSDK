<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK\Structure;

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;
use Tinque\SGDFIntranetSDK\Structure\StructureInformations;

class Structure {
	
	private $mName = -1;
	private $mCodeStructure = - 1;
	private $mCodeStructureParente = null;
	
	function __construct()
	{
		//void
	}
	
	/**
	 * Retourne les informations sur l'adherant
	 * @param SGDFIntranetUser $user
	 * @return \Tinque\SGDFIntranetSDK\Structure\StructureInformations
	 */
	public function createStructureInformations(SGDFIntranetUser &$user)
	{
		return new StructureInformations($user, $this->mCodeStructure);
	}
	
	/*
	 * Getters 
	 */
	
	public function getName()
	{
		return $this->mName;
	}
	
	public function getCodeStructure()
	{
		return $this->mCodeStructure;
	}
	
	public function getCodeStructureParente()
	{
		return $this->mCodeStructureParente;
	}
	
	/*
	 * Setters
	 */
	
	public function setName($name)
	{
		$this->mName = $name;
		return $this;
	}
	
	public function setCodeStructure($codestructure)
	{
		$this->mCodeStructure = $codestructure;
		return $this;
	}
	
	public function setCodeStructureParente($codestructureparente)
	{
		$this->mCodeStructureParente = $codestructureparente;
		return $this;
	}
}