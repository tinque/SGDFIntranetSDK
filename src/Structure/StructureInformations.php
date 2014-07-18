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
use Tinque\SGDFIntranetSDK\SGDFIntranetError;


class StructureInformations {
	
	private $mUser;
	private $mCodeStructure = -1;


	private $mCodeStructureParente = -1;
	
	private $mNom = -1;

	/**
	 * 
	 * @param SGDFIntranetUser $user utilisateur de l'intranet
	 * @param string $codestructure code la structure
	 */
	function __construct(SGDFIntranetUser $user, $codestructure)
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
                        $crawler = $this->mUser->getClientGoutte()->request('GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/structures/RechercherStructure.aspx?code='.$this->mCodeStructure);
		
			if($crawler->filter('html:contains("Rechercher une structure")')->count() == 0)
			{
				if($crawler->filter('html:contains("Accès interdit")')->count() != 0)
				{
					$this->mCodeStructureParente = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__gvParents > .ligne1 > td')->text();
					$this->mNom = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__resume__lblNom')->text();
				}
				else
				{
					throw new SGDFIntranetError('Absence de droit de lecture de la structure');
				}

			}
			else
			{
				throw new SGDFIntranetError('Impossible de trouver la structure');
			}
		


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
}
