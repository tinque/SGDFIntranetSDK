<?php

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
	private $mStructure = - 1;
	private $mCodeStructure = - 1;
	function __construct(SGDFIntranetUser $user) {
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
			
			$this->mPrenom = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__resumeDeclarationTamIntervenant__lbPrenom')->text();
			$this->mNom = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__resumeDeclarationTamIntervenant__lbNom')->text();
			$this->mCivilite = $crawler->filter('#ctl00_ctl00_MainContent_DivsContent__resumeDeclarationTamIntervenant__lbCivilite')->text();
			
			
			$this->mFonction = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonction' )->text ();
			$this->mCodeFonction = preg_replace ( '#^([0-9]+).*$#', '$1', $this->mFonction );
			$this->mFonctionSecondaire = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblFonctionsSecondaires' )->text ();
			$this->mStatut = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblTypeInscription' )->text ();
			$this->mCodeAdherant = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__lblCodeAdherent' )->text ();
			$this->mDDN = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__lblDateNaissance' )->text ();
			
			$this->mEmail = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__modeleIndividu__hlCourrielPersonnel' )->text ();
			
			$this->mStructure = $crawler->filter ( '#ctl00_ctl00_MainContent_DivsContent__resume__hlStructure' )->text ();
			$this->mCodeStructure = preg_replace ( '#^([0-9]+).*$#', '$1', $this->mStructure );
		}
	}
	public function refresh() {
		$this->loadInformations ();
	}
	public function getLogin() {
		return $this->mUser->getLogin ();
	}
	
	public function getPrenom()
	{
		return $this->mPrenom;
	}
	public function getNom()
	{
		return $this->mNom;
	}
	public function getCivilite()
	{
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
	public function getStructure() {
		return $this->mStructure;
	}
	public function getCodeStructure() {
		return $this->mCodeStructure;
	}
}
