#Intranet SGDF - SDK

Ce SDK propose une API simple pour inter-agir avec l'intranet des Scouts et Guides de France.


##Dépendance

Le SDK d&eacute;pend de Goutte et necessitte donc PHP 5.4+

## Installation

Ajouter ``Tinque/SGDFIntranetSDK`` en tant que d&eacute;pendance &agrave; votre fichier ``composer.json``

```bash
    php composer.phar require Tinque/SGDFIntranetSDK:dev-master
```

##Usage

Creer un objet SGDFIntranetUser en lui passant comme param&egrave;tre le login et le mot de passe de l'utilisateur intranet

```php
	use Tinque\SGDFIntranetSDK\SGDFIntranetUser;
	
	$user = new SGDFIntranetUser('login','password')
```

V&eacute;rifier que les authentifiants sont corrects :

```php
	if($user->areCredentialsValid())
	{
		//true
	
	}
	else
	{
		//false
		
	}
```

##Documentation

J'ai &eacute;crit ce SDK rapidement et comme on dit :
> Quick and cheap but dirty

Alors pour l'instant il n'y a pas de docs :sunglasses: 
mais un jour si &ccedil;a &eacute;volue la documentation se trouvera dans le repertoire [docs](docs)

	

##Licence

Le SDK est sous Licence [Beerware](LICENSE "Licence") 

![Beerware Logo](http://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/BeerWare_Logo.svg/116px-BeerWare_Logo.svg.png "Beerware Logo")

Pour plus d'infos sur la licence [Beerware](http://en.wikipedia.org/wiki/Beerware)


