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

use \Tinque\SGDFIntranetSDK\SGDFIntranetUser;
use \Tinque\SGDFIntranetSDK\SGDFIntranetException;
use Tinque\SGDFIntranetSDK\Tools\NameHelper;
use Tinque\SGDFIntranetSDK\Tools\CalculeHelper;


class StructureInformations {
	
	private $mUser;
	private $mCodeStructure = -1;
	

	private $mDepartement = -1;
	private $mType = -1;
	private $mTelephone = -1;

	private $mCodeStructureParente = -1;
	
	private $mNom = -1;

	/**
	 * 
	 * @param SGDFIntranetUser $user utilisateur de l'intranet
	 * @param string $codestructure code la structure
	 */
	function __construct(SGDFIntranetUser &$user, $codestructure)
	{
		$this->mUser =$user;
		$this->mCodeStructure = $codestructure;
		$this->loadInformations();
	}



	private function loadInformations()
	{
		if(!$this->mUser->checkConnection())
                {
                        $this->mUser->reConnect();
                }

		if($this->mUser->isConnected())
                {
               
                	
                	$crawler = $this->mUser->getClientGoutte()->request('GET', 'https://intranet.sgdf.fr/popups/RechercheStructure.aspx?operations=');
					$form = $crawler->filter('#ctl00_Popup__recherche_Rechercher')->form();
			
			
					$crawler = $this->mUser->getClientGoutte()->submit ( $form, array (
							'ctl00$Popup$_recherche$_tbCodeStructure' => $this->mCodeStructure
					) );

					$crawler->filter("#ctl00_Popup__recherche__gvResultats > tr")->siblings()->each(
							function ($node)
							{
					
								
								$struct = NameHelper::SplitCodeStructureAndName($node->filter('td')->eq(1)->text());
								if($struct['codestructure'] == $this->mCodeStructure)
								{
									$this->mNom = $struct['namestructure'];
									
									$this->mCodeStructureParente = CalculeHelper::getCodeStructureParente($this->mCodeStructure);
									$this->mDepartement = $node->filter('td')->eq(3)->text();
									$this->mType = $node->filter('td')->eq(4)->text();
									$this->mTelephone = $node->filter('td')->eq(5)->text();
									
									
								}
								else
								{
									throw new SGDFIntranetException('Erreur inconnue',SGDFIntranetException::SGDF_ERROR_UNDEFINED);
								}
								
					
								
								
								
							
							}
					);
			}

	}

	/**
	 * Rafraichit les informations de l'objet
	 */
	public function refresh()
	{
		$this->loadInformations();
		
	}
	
	/**
	 * retourne le code de la structure parente
	 * @return string Code de la structure
	 */

	public function getCodeStructureParente()
	{

		return  $this->mCodeStructureParente;
	}


	/**
	 * 
	 * @return string Nom de la structure
	 */
	public function getNom()
	{
		return $this->mNom;
	}
	
	public function getDepartement()
	{
		return $this->mDepartement;
	}
	
	public function getType()
	{
		return $this->mType;
	}
	
	public function getTelephone()
	{
		return $this->mTelephone;
	}
	
	public function  getCodeStructure()
	{
		return $this->mCodeStructure;
	}
}
