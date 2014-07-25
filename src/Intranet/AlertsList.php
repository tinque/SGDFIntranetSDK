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

use Tinque\SGDFIntranetSDK\SGDFIntranetUser;

class AlertsList {
	
	private $mList = array();
	private $mUser;
	
	/**
	 * 
	 * @param SGDFIntranetUser $user utilisateur de l'intranet
	 */
	function __construct(SGDFIntranetUser &$user)
	{
		$this->mUser =$user;
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
			
			$crawler = $this->mUser->getClientGoutte()->request('GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/Accueil.aspx');
			

			
			try {
				$crawler->filter('#ctl00_MainContent__boxAlertes > div')->siblings()->each(
						function ($node)
						{
							if($node->attr('class') == "item")
							{
								$alert = new Alert();
								$alert->setTitre(trim(preg_replace("#^(.*)[:][ ]$#", "$1", $node->filter('b')->text())));
									
								$alert->setTexte(trim(preg_replace("#^.*".trim($node->filter('b')->text())."(.*)$#is", "$1", $node->text())));
								array_push($this->mList, $alert);
							}
				
				
						}
				);
			}catch (\Exception $e)
			{
				
			}
		
			
			
		}
	}
	
	
	/*
	 * Getters 
	 */
	
	public function getAlerts()
	{
		return $this->mList;
	}

	
}