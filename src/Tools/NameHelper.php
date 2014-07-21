<?php


/*
 * --------------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <quentin.georget@gmail.com> wrote this file. As long as you retain this notice
* you can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Tinque
* --------------------------------------------------------------------------------
*/


namespace Tinque\SGDFIntranetSDK\Tools;



class NameHelper {
	static function SpliFullName($fullname, array $familyFullNames) {
		
		// Recherche de la civilite
		$civilite = preg_replace ( "#^(.*[\.|e]) .*$#", "$1", $fullname );
		
		// suppresion de la civilite
		$fullname = trim ( preg_replace ( "#^" . $civilite . "(.*)$#", "$1", $fullname ) );
		
		$name = "";
		
		$tmpnames = explode ( " ", $fullname );
		// parcour des noms
		foreach ( $tmpnames as $tmpname ) {
			// parcours des membres de la famille
			foreach ( $familyFullNames as $familyname ) {
				// test si le nom est commun avec la famille
				if (preg_match ( "/" . $tmpname . "/i", $familyname ) == 1) {
					// test si le nom est deja present
					if (preg_match ( "/" . $tmpname . "/i", $name ) == 0) {
						$name .= " " . $tmpname;
					}
				}
			}
		}
		
		$name = trim ( $name );
		
		if ($name == "") {
			$nb_space = substr_count ( $fullname, ' ' );
			$tmpname = explode ( " ", $fullname );
			
			// FORMAT: NOM PRENOM
			if ($nb_space == 1) {
				$name = $tmpname [0];
			} elseif ($nb_space == 2) {
				
				// suppose que le prenom est un nom composé
				$name = $tmpname [0];
			} else {
				
				// suppose prenom et nom composé
				
				for($i = 0; $i < $nb_space - 3; $i ++) {
					$name .= " " . $tmpname [$i];
				}
			}
			$name = trim ( $name );
		}
		
		$prenom = trim ( preg_replace ( "#^" . $name . "(.*)$#", "$1", $fullname ) );
		return array (
				"civilite" => $civilite,
				"nom" => $name,
				"prenom" => $prenom 
		);
	}
}