<?php

namespace Tinque\SGDFIntranetSDK\Structure;

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;


class StructureInformations {
	
	private $mUser;
	private $mCodeStructure = -1;


	private $mCodeStructureParente = -1;
	
	private $mNom = -1;

	
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
				$this->mCodeStructureParente = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__gvParents > .ligne1 > td')->text();
				$this->mNom = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__resume__lblNom')->text();
			}
			else
			{
				//TODO throw error
			}
		


                }

	}

	public function refresh()
	{
		$this->loadInformations();
		
	}

	public function getCodeStructureParente()
	{

		return  $this->mCodeStructureParente;
	}


	public function getNom()
	{
		return $this->mNom;
	}
}
