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
use Tinque\SGDFIntranetSDK\SGDFIntranetException;
use Tinque\SGDFIntranetSDK\Tools\NameHelper;


class AdherantInformations {
	
	private $mUser;
	private $mCodeAdherant;
	
	private $mTitre = -1;
	
	private $mNom = - 1;
	private $mPrenom = - 1;
	private $mCivilite = - 1;
	
	private $mFamille = array();
	private $mPere = -1;
	private $mMere = -1;
	
	private $mFonction = - 1;
	private $mCodeFonction = - 1;
	private $mFonctionSecondaire = - 1;
	private $mStatut = - 1;
	private $mDDN = - 1;
	private $mEmail = - 1;
	private $mEmailPro = - 1;
	private $mTelDomicile = -1;
	private $mTelProfessionel = -1;
	private $mTelPortable1 = -1;
	private $mTelPortable2 = -1;
	
	private $mAdresse = -1;
	private $mCodePostal =  -1;
	private $mVille = -1;
	private $mPays = -1;
	
	
	
	
	private $mStructure = - 1;
	private $mCodeStructure = - 1;
	
	/**
	 * 
	 * @param SGDFIntranetUser $user
	 * @param string $codeAdherant
	 */
	
	function __construct(SGDFIntranetUser $user,$codeAdherant) {
		$this->mUser = $user;
		$this->mCodeAdherant = $codeAdherant;
		$this->loadInformations ();
	}
	private function loadInformations() {
		if (! $this->mUser->checkConnection ()) {
			$this->mUser->reConnect ();
		}
	
		if ($this->mUser->isConnected ()) {

			
			$crawler = $this->mUser->getClientGoutte()->request('GET', 'https://intranet.sgdf.fr/Specialisation/Sgdf/adherents/RechercherAdherent.aspx?code='.$this->mCodeAdherant);

			
			
			
			if($crawler->filter('html:contains("Aucun adh")')->count() == 0)
			{
				
				if($crawler->filter('html:contains("interdit")')->count() == 0)
				{
					
					
					$crawler->filter('#ctl00_ctl00_MainContent_DivsContent__famille__lblFamille > a')->each(
							function($node)
							{
								
								array_push($this->mFamille,$node->text());
								
							}
					);
					
			
					
					try{
						$this->mPere = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__famille__hlPere')->text();
					}catch (\Exception $e)
					{
						$this->mPere = "";
					}
					
					try{
						$this->mMere = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__famille__hlMere')->text();
					}catch (\Exception $e)
					{
						$this->mMere = "";
					}
									
					$this->mTitre = $crawler->filter ('#ctl00_ctl00__divTitre')->text();
					
					$familyNames = $this->mFamille;
					array_push($familyNames, $this->mPere,$this->mMere);
					$splitname = NameHelper::SpliFullName($this->mTitre,$familyNames );
						
					
					$this->mCivilite = $splitname['civilite'];
					$this->mPrenom = $splitname['prenom'];
					$this->mNom = $splitname['nom'];
					
					
					$this->mFonction = preg_replace ( '#^[0-9]+ \((.*)\)$#', '$1',$crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonction' )->text ());
					$this->mCodeFonction = preg_replace ( '#^([0-9]+).*$#', '$1', $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonction' )->text () );
					$this->mFonctionSecondaire = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonctionsSecondaires' )->text ();
						
						
						
					$this->mStatut = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblTypeInscription' )->text ();
					$this->mCodeAdherant = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblCodeAdherent' )->text ();
					$this->mDDN = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblDateNaissance' )->text ();
						
					$this->mEmail = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__hlCourrielPersonnel' )->text ();
					$this->mEmailPro = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__hlCourrielProfessionnel')->text();
						
					$this->mTelDomicile = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephoneDomicile')->text();
					$this->mTelProfessionel = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephoneBureau')->text();
					$this->mTelPortable1 = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephonePortable1')->text();
					$this->mTelPortable2 = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephonePortable2')->text();
						
					$this->mAdresse = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbLigne1')->text();
					$this->mCodePostal = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbCodePostal')->text();
					$this->mVille = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbVille')->text();
					$this->mPays = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbPays')->text();
						
						
					$this->mStructure = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__hlStructure' )->text ();
					$this->mCodeStructure = preg_replace ( '#^([0-9]+).*$#', '$1', $this->mStructure );
					
				}
				else
				{
					throw new SGDFIntranetException('Absence de droit de lecturesur l\'adherant',SGDFIntranetException::SGDF_ERROR_NO_RIGHT);
				}
			}
			else 
			{
				throw new SGDFIntranetException('Impossible de trouver l\'adhérant',SGDFIntranetException::SGDF_ERROR_NOT_FOUND);
			}
		}
		else 
		{
			throw new SGDFIntranetException('Imposible de se connecter pour récupérer les infos de l\'adherant',SGDFIntranetException::SGDF_ERROR_NO_INTRANET_CONNEXION);
		}

	}
	
	
	/*
	 * Getters
	*/
	public function getLogin() {
		return $this->mUser->getLogin ();
	}
	
	public function getPrenom() {
		return $this->mPrenom;
	}
	public function getNom() {
		return $this->mNom;
	}
	public function getCivilite() {
		return $this->mCivilite;
	}

	public function getTitre() {
		return $this->mTitre;
	}
	public function areCredentialsValid() {
		return $this->mUser->areCredentialsValid ();
	}
	public function isConnected() {
		return $this->mUser->isConnected ();
	}
	public function getFonction() {
		return $this->mFonction;
	}
	public function getCodeFonction() {
		return $this->mCodeFonction;
	}
	public function getFonctionSecondaire() {
		return $this->mFonctionSecondaire;
	}
	public function getStatut() {
		return $this->mStatut;
	}
	public function getCodeAdherant() {
		return $this->mCodeAdherant;
	}
	public function getDDN() {
		return $this->mDDN;
	}
	public function getEmail() {
		return $this->mEmail;
	}
	public function getEmailPro() {
		return $this->mEmailPro;
	}
	
	public function getTelDomicile() {
		return $this->mTelDomicile;
	}
	
	public function getTelProfessionel() {
		return $this->mTelProfessionel;
	}
	public function getTelPortable1() {
		return $this->mTelPortable1;
	}
	public function getTelPortable2() {
		return $this->mTelPortable2;
	}
	
	public function getAdresse() {
		return $this->mAdresse;
	}
	
	public function getCodePostal() {
		return $this->mCodePostal;
	}
	public function getVille() {
		return $this->mVille;
	}
	public function getPays() {
		return $this->mPays;
	}
	
	
	public function getStructure() {
		return $this->mStructure;
	}
	public function getCodeStructure() {
		return $this->mCodeStructure;
	}
	


}