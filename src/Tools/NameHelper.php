<?php 


namespace Tinque\SGDFIntranetSDK\Tools;

class NameHelper {
	
	
	static function SpliFullName($fullname, array $familyFullNames)
	{
		
		//Recherche de la civilite
		$civilite = preg_replace("#^(.*[\.|e]) .*$#", "$1", $fullname);
		
		//suppresion de la civilite
		$fullname = trim(preg_replace("#^".$civilite."(.*)$#", "$1", $fullname));
		
		$name = "";
		
		$tmpnames = explode(" ",$fullname);
		//parcour des noms
		foreach ($tmpnames as $tmpname)
		{	
			//parcours des membres de la famille
			foreach ($familyFullNames as $familyname)
			{
				//test si le nom est commun avec la famille
				if(preg_match("/".$tmpname."/i", $familyname) == 1)
				{
					//test si le nom est deja present
					if(preg_match("/".$tmpname."/i", $name) == 0)
					{
						$name .= " ".$tmpname;
					}
					
				}
			}
		}
		
		$name = trim($name);
		
		$prenom = trim(preg_replace("#^".$name."(.*)$#", "$1", $fullname));
		
		return array("civilite" => $civilite,"nom"=>$name, "prenom"=>$prenom);
		
		
	}
	
	
}