<?php

if(!isset($_SESSION)) { 
	session_start();
}

require './includes/common/recaptcha.php';
include_once('./includes/common/verif_security.php');
include_once('./includes/common/mailing.php');
include_once('./includes/public/functions.php');

try {
	verif_origin_user();
} catch (Exception $e) {
	header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error1');
	die();
}

/* vérification du captcha*/
$captcha = new Recaptcha ('6LdidxgTAAAAAHGefCS0_l2eyEeXVWh4lRFVHyzj', '6LdidxgTAAAAAA-7SGtTTaso_qETEZ6-fg_XUYOz');
if (!empty($_POST)) {
	if ($captcha->isValid($_POST['g-recaptcha-response']) == false) {
		header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error2');
		die();
	}

	if (isset($_POST['firstname'])  
		&& isset($_POST['lastname']) 		
		&& isset($_POST['email']) 	
		&& isset($_POST['city']) 
		&& isset($_POST['cp']) 
		&& isset($_POST['country']) 
		&& isset($_POST['newsletter']) 		
		&& isset($_POST['marque']) 
		&& isset($_POST['model']) 
		&& isset($_POST['type']) 
		&& isset($_POST['motorisation']) 
		&& isset($_POST['immat'])
		&& isset($_POST['date_circu']) 	
		&& isset($_POST['infos'])		
		) {


		/* sécurisation faille XSS*/

		if (isset($_POST['concours1'])) {
			$concours1 = true;
		} else {
			$concours1 = false;
		}
		if (isset($_POST['concours2'])) {
			$concours2 = true;
		} else {
			$concours2 = false;
		}
		if (isset($_POST['concours3'])) {
			$concours3 = true;
		} else {
			$concours3 = false;
		}

		$exposant = [
			'firstname' => htmlspecialchars($_POST['firstname']), 
			'lastname' => htmlspecialchars($_POST['lastname']),			
			'email' => htmlspecialchars($_POST['email']),
			'city' => htmlspecialchars($_POST['city']),
			'cp' => htmlspecialchars($_POST['cp']),			
			'country' => htmlspecialchars($_POST['country']),
			'newsletter' => htmlspecialchars($_POST['newsletter']),
			'club' => htmlspecialchars($_POST['club']),		
			'marque' => htmlspecialchars($_POST['marque']),
			'model' => htmlspecialchars($_POST['model']),
			'type' => htmlspecialchars($_POST['type']),
			'motorisation' => htmlspecialchars($_POST['motorisation']),
			'immat' => htmlspecialchars($_POST['immat']),
			'date_circu' => htmlspecialchars($_POST['date_circu']),
			'infos' => htmlspecialchars($_POST['infos']),
			'concours1' => $concours1,
			'concours2' => $concours2,
			'concours3' => $concours3
			];

		
		try {
			/* inscription dans la bdd*/

			$exposant_id = ajouter_inscription($exposant);

			try {

				/* envoi emails*/
			envoi_mail("inscription", $exposant_id);
			envoi_mail("nouvel_inscrit", $exposant_id);			
				/*  */

			/* retour à la page des Bielles Meusiennes avec un message de réussite ou d'erreur */
			
			header('Location: http://hiddenj.jimdo.com/design-formulaire-1/success');
			} catch (Exception $e) {
				/* effacer les données dans la bdd*/

				/* */
				header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error3');
			}
			
		} catch (Exception $e) {		
			
			header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error4');
		}
	} else {		
		header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error5');
	}
}

?>