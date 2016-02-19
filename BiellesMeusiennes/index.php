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
	header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error');
	die();
}

/* vérification du captcha*/
$captcha = new Recaptcha ('6LdidxgTAAAAAHGefCS0_l2eyEeXVWh4lRFVHyzj', '6LdidxgTAAAAAA-7SGtTTaso_qETEZ6-fg_XUYOz');
if (!empty($_POST)) {
	if ($captcha->isValid($_POST['g-recaptcha-response']) == false) {
		header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error');
		die();
	}



	if (isset($_POST['type']) && (!empty($_POST['type']))
		&& isset($_POST['firstname']) && (!empty($_POST['firstname'])) 
		&& isset($_POST['lastname']) && (!empty($_POST['lastname']))		
		&& isset($_POST['email']) && (!empty($_POST['email']))
		&& isset($_POST['phone']) && (!empty($_POST['phone']))
		&& isset($_POST['adress1']) && (!empty($_POST['adress1']))
		&& isset($_POST['adress2'])
		&& isset($_POST['adress3'])
		&& isset($_POST['city']) && (!empty($_POST['city'])) 
		&& isset($_POST['cp']) && (!empty($_POST['cp']))
		&& isset($_POST['country']) && (!empty($_POST['country'])) 
		&& isset($_POST['cedex'])		
		&& isset($_POST['marque']) && (!empty($_POST['marque'])) 
		&& isset($_POST['model']) && (!empty($_POST['model'])) 
		&& isset($_POST['serie']) && (!empty($_POST['serie'])) 
		&& isset($_POST['motorisation']) && (!empty($_POST['motorisation'])) 
		&& isset($_POST['immat'])
		&& isset($_POST['date_circu']) && (!empty($_POST['date_circu'])) 		
		&& isset($_POST['infos'])
		&& isset($_POST['model_info'])
		&& isset($_POST['club'])
		) {
		/* sécurisation faille XSS*/
		$donneesOwner = [
			'firstname' => htmlspecialchars($_POST['firstname']), 
			'lastname' => htmlspecialchars($_POST['lastname']),
			'type' => htmlspecialchars($_POST['type']), 
			'email' => htmlspecialchars($_POST['email']),
			'phone' => htmlspecialchars($_POST['phone']),
			'adress1' => htmlspecialchars($_POST['adress1']), 
			'adress2' => htmlspecialchars($_POST['adress2']), 
			'adress3' => htmlspecialchars($_POST['adress3']),
			'city' => htmlspecialchars($_POST['city']),
			'cp' => htmlspecialchars($_POST['cp']),
			'cedex' => htmlspecialchars($_POST['cedex']),
			'country' => htmlspecialchars($_POST['country']),
			'newsletter' => "NON",
			'club' => htmlspecialchars($_POST['club'])		
			];
		$donneesVehicle = [
			'marque' => htmlspecialchars($_POST['marque']),
			'model' => htmlspecialchars($_POST['model']),
			'serie' => htmlspecialchars($_POST['serie']),
			'motorisation' => htmlspecialchars($_POST['motorisation']),
			'model_info' => htmlspecialchars($_POST['model_info']),
			'date_circu' => htmlspecialchars($_POST['date_circu']),
			'imat' => htmlspecialchars($_POST['immat']),
			'infos' => htmlspecialchars($_POST['infos'])
			];
		try {
			/* inscription dans la bdd*/

			$owner_id = ajouter_inscription($donneesOwner, $donneesVehicle);

			try {

				/* envoi emails*/
			envoi_mail("inscription", $donneesOwner['email'], $owner_id);
			envoi_mail("nouvel_inscrit", "localhost@local.io", $owner_id);			
				/*  */

			/* retour à la page des Bielles Meusiennes avec un message de réussite ou d'erreur */
			
			header('Location: http://hiddenj.jimdo.com/design-formulaire-1/success');
			} catch (Exception $e) {
				/* effacer les données dans la bdd*/

				/* */
				header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error');
			}
			
		} catch (Exception $e) {		
			
			header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error');
		}
	} else {
		
		header('Location: http://hiddenj.jimdo.com/design-formulaire-1/error');
	}
}

?>