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

class ProfileInformations {
	private $mUser;
	private $mNom = - 1;
	private $mPrenom = - 1;
	private $mCivilite = - 1;
	private $mFonction = - 1;
	private $mCodeFonction = - 1;
	private $mFonctionSecondaire = - 1;
	private $mStatut = - 1;
	private $mCodeAdherant = - 1;
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
	 * @param SGDFIntranetUser $user utilisateur intranet
	 */
	
	function __construct(SGDFIntranetUser &$user) {
		$this->mUser = $user;
		$this->loadInformations ();
	}
	private function loadInformations() {
		if (! $this->mUser->checkConnection ()) {
			$this->mUser->reConnect ();
		}
		
		if ($this->mUser->isConnected ()) {
			$crawler = $this->mUser->getClientGoutte ()->request ( 'GET', 'https://intranet.sgdf.fr/Accueil.aspx' );
			$link = $crawler->selectLink ( 'Voir ma fiche adhérent' )->link ();
			
			$crawler = $this->mUser->getClientGoutte ()->click ( $link );
			
			$this->mFonction = preg_replace ( '#^[0-9]+ \((.*)\)$#', '$1',$crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonction' )->text ());
			$this->mCodeFonction = preg_replace ( '#^([0-9]+).*$#', '$1', $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonction' )->text ());
			$this->mFonctionSecondaire = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonctionsSecondaires' )->text ();
			
			
			
			$this->mStatut = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblTypeInscription' )->text ();
			$this->mCodeAdherant = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblCodeAdherent' )->text ();
			$this->mDDN = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblDateNaissance' )->text ();
			
			$this->mEmail = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__hlCourrielPersonnel' )->text ();
			$this->mEmailPro = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__hlCourrielProfessionnel')->text();
			
			$this->mTelDomicile = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephoneDomicile')->text();
			$this->mTelProfessionel = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephoneBureau')->text();
			$this->mTelPortable1 = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephonePortable1')->text();
			//Peut avoir un /
			$this->mTelPortable2 = preg_replace( '#[/|] ([0-9]+)#', '$1',trim($crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblTelephonePortable2')->text()));
				
			
			try {
				$this->mAdresse = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbLigne1')->text();
			} catch (Exception $e) {
				try {
					$this->mAdresse = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbLigne2')->text();
				} catch (Exception $e) {
				}
			}
			
			$this->mCodePostal = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbCodePostal')->text();
			$this->mVille = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbVille')->text();
			$this->mPays = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__resumeAdresse__lbPays')->text();
			
			
			$this->mStructure = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__hlStructure' )->text ();
			$this->mCodeStructure = preg_replace ( '#^([0-9]+).*$#', '$1', $this->mStructure );
			
			
			$link = $crawler->selectLink ( 'Modifier l\'adhérent' )->link ();
				
			$crawler = $this->mUser->getClientGoutte ()->click ( $link );
				
			$form = $crawler->filter ( '#ctl00_MainContent__editAdherent__btnValider' )->form ();
			
			//var_dump($form);
			
			/*
			 * 1 Monsieur
			 * 2 Madame
			 * 3 Mademoiselle
			 * 5 Monseigneur
			 * 6 Père
			 * 7 Soeur
			 * 9 Frère
			 */
			$this->mCivilite = $form->get('ctl00$MainContent$_editAdherent$_editIdentite$_ddCivilite')->getValue();
			
			
			
			$this->mNom = $form->get('ctl00$MainContent$_editAdherent$_editIdentite$_tbNom')->getValue();
			$this->mPrenom = $form->get('ctl00$MainContent$_editAdherent$_editIdentite$_tbPrenom')->getValue();
			
			
			
			
			
		}
	}
	public function refresh() {
		$this->loadInformations ();
	}
	public function save() {
		if (! $this->mUser->checkConnection ()) {
			$this->mUser->reConnect ();
		}
		
		if ($this->mUser->isConnected ()) {
			
			$crawler = $this->mUser->getClientGoutte ()->request ( 'GET', 'https://intranet.sgdf.fr/Accueil.aspx' );
			$link = $crawler->selectLink ( 'Voir ma fiche adhérent' )->link ();
			
			$crawler = $this->mUser->getClientGoutte ()->click ( $link );
			
			$link = $crawler->selectLink ( 'Modifier l\'adhérent' )->link ();
			
			$crawler = $this->mUser->getClientGoutte ()->click ( $link );
			
			$form = $crawler->filter ( '#ctl00_MainContent__editAdherent__btnValider' )->form ();
			
			$crawler = $this->mUser->getClientGoutte ()->submit ( $form, array (
					'ctl00$MainContent$_editAdherent$_editInformations$_tbCourrielPersonnel' => $this->mEmail,
					'ctl00$MainContent$_editAdherent$_editInformations$_tbCourrielProfessionnel' => $this->mEmailPro,
					 
			) );
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
	
	
	
	
	/*
	 * Setters
	 */
	public function setEmail($email) {
		$this->mEmail = $email;
	}
	public function setEmailPro($emailPro) {
		$this->mEmailPro = $emailPro;
	}
}
