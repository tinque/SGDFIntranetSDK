<?php

/*
 * --------------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
 * you can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Tinque
 * --------------------------------------------------------------------------------
 */
namespace Tinque\SGDFIntranetSDK\User;

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;
use Tinque\SGDFIntranetSDK\SGDFIntranetException;
use Tinque\SGDFIntranetSDK\Adherant\Adherant;
use Tinque\SGDFIntranetSDK\Structure\Structure;
use Tinque\SGDFIntranetSDK\Tools\NameHelper;

class UserStructure {
	
	private $mUser;
	private $mStructure = null;
	private $mListeAdherants = array();
	
	function __construct(SGDFIntranetUser &$user) {
		$this->mUser = $user;
		$this->loadInformations ();
	}
	
	
	private function loadInformations() {
		if (! $this->mUser->checkConnection ()) {
			$this->mUser->reConnect ();
		}
	
		if ($this->mUser->isConnected ()) {
			
			$crawler = $this->mUser->getClientGoutte()->request('GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/adherents/ListeAdherents.aspx');
			

			$this->mStructure = new Structure();
			$structtmp = NameHelper::SplitCodeStructureAndName($crawler->filter("#ctl00_MainContent__navigateur__ddStructures")->text());
			$this->mStructure->setName($structtmp['namestructure'])->setCodeStructure($structtmp['codestructure']);
			
			$crawler->filter("#ctl00_MainContent__gvMembres > tr")->siblings()->each(
					function ($node)
					{
						
						
						
						$tmpadherant = new Adherant();
						
						$tmpadherant
							->setCodeFonction($node->filter('td')->eq(2)->text())
							->setNomPrenom($node->filter('td')->eq(0)->text())
							->setCodeAdherant($node->filter('td')->eq(1)->text())
							;
						array_push($this->mListeAdherants, $tmpadherant);
					}
			);
			
			
		}
		else
		{
			throw new SGDFIntranetException('Imposible de se connecter pour recuperer les infos structures user',SGDFIntranetException::SGDF_ERROR_NO_INTRANET_CONNEXION);
		}
	}
	
	/**
	 * Retourne la listes des adherants de la structure
	 * 
	 * @return Adherant[]:
	 */
	public function getListeAdherants()
	{
		return $this->mListeAdherants;
	}
	
	public function getUserStructure()
	{
		return $this->mStructure;
	}
	
}