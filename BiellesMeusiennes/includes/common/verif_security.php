<?php
/*cette fonction génère un token de session pour le compte administrateur */
function generer_token() {
	if(!isset($_SESSION)) { 
		session_start();
	}
	$token = md5 (time()*rand(224, 698));
	$_SESSION['_token']= $token;
	return $token;
}

/* cette fonction vérifie la provenance de l'user, et le token pour le cas admin*/
function verif_origin_user () {
	if(!isset($_SESSION)) { 
		session_start();
	}
	if (isset($_SERVER['HTTP_REFERER'])) {
		/*si l'utilisateur est sur le site admin, il doit avoir une session active qui n'existe qu'après login, sécurisée par la présence d'un token propre à la session*/
		if (preg_match("#^http:\/\/localhost\/BiellesMeusiennes\/BiellesMeusiennes\/admin#", $_SERVER['HTTP_REFERER'])) {
			if (!isset($_GET['token'])) {
				throw new Exception ('pas de token');
			}  else if ($_GET['token'] != $_SESSION['_token']) {
				throw new Exception ('jeton de sécurité périmé');
			}
		}
		/* sécurisation failles CSRF. on refuse toute connexion qui provient d'un autre site que celui des Bielles Meusiennes public*/
		else if (!preg_match("#^http:\/\/hiddenj.jimdo.com\/#", $_SERVER['HTTP_REFERER'])) {
			throw new Exception ('vous venez de ce site non autorisé : '. $_SERVER['HTTP_REFERER']);
		}		
	} else {
		throw new Exception ('On ne sait pas d\'où vous venez');
	}
}	
?>