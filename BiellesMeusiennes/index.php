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
	header('Location: http://localhost/site distant autorise/hack.html');
	die();
}

/* vérification du captcha*/
$captcha = new Recaptcha ('6LdLehgTAAAAAFmYf4DDe7hadxGYRfDiuw2UMgCr', '6LdLehgTAAAAAG05QDDI0YknJWRASpPYoly9y4Cp');
if (!empty($_POST)) {
	if ($captcha->isValid($_POST['g-recaptcha-response']) == false) {
		header('Location: http://localhost/site distant autorise/hack.html');
		die();
	}



	if (isset($_POST['firstname']) && (!empty($_POST['firstname'])) 
		&& isset($_POST['lastname']) && (!empty($_POST['lastname'])) 
		&& isset($_POST['type']) && (!empty($_POST['type'])) 
		&& isset($_POST['email']) && (!empty($_POST['email'])) 
		&& isset($_POST['adress1']) && (!empty($_POST['adress1']))
		&& isset($_POST['adress2'])
		&& isset($_POST['adress3'])
		&& isset($_POST['city']) && (!empty($_POST['city'])) 
		&& isset($_POST['cp']) && (!empty($_POST['cp'])) 
		&& isset($_POST['cedex'])
		&& isset($_POST['country']) && (!empty($_POST['country'])) 
		&& isset($_POST['club'])
		&& isset($_POST['marque']) && (!empty($_POST['marque'])) 
		&& isset($_POST['model']) && (!empty($_POST['model'])) 
		&& isset($_POST['serie']) && (!empty($_POST['serie'])) 
		&& isset($_POST['motorisation']) && (!empty($_POST['motorisation'])) 
		&& isset($_POST['model_info'])
		&& isset($_POST['date_circu']) && (!empty($_POST['date_circu'])) 
		&& isset($_POST['imat'])
		&& isset($_POST['infos'])
		) {
		/* sécurisation faille XSS*/
		$donneesOwner = [
			'firstname' => htmlspecialchars($_POST['firstname']), 
			'lastname' => htmlspecialchars($_POST['lastname']),
			'type' => htmlspecialchars($_POST['type']), 
			'email' => htmlspecialchars($_POST['email']), 
			'adress1' => htmlspecialchars($_POST['adress1']), 
			'adress2' => htmlspecialchars($_POST['adress2']), 
			'adress3' => htmlspecialchars($_POST['adress3']),
			'city' => htmlspecialchars($_POST['city']),
			'cp' => htmlspecialchars($_POST['cp']),
			'cedex' => htmlspecialchars($_POST['cedex']),
			'country' => htmlspecialchars($_POST['country']),
			'club' => htmlspecialchars($_POST['club'])		
			];
		$donneesVehicle = [
			'marque' => htmlspecialchars($_POST['marque']),
			'model' => htmlspecialchars($_POST['model']),
			'serie' => htmlspecialchars($_POST['serie']),
			'motorisation' => htmlspecialchars($_POST['motorisation']),
			'model_info' => htmlspecialchars($_POST['model_info']),
			'date_circu' => htmlspecialchars($_POST['date_circu']),
			'imat' => htmlspecialchars($_POST['imat']),
			'infos' => htmlspecialchars($_POST['infos'])
			];
		try {
			/* inscription dans la bdd*/

			ajouter_inscription($donneesOwner, $donneesVehicle);

			try {

				/* envoi emails*/
			envoi_mail("inscription", $donneesOwner['email'], $donneesOwner, $donneesVehicle);
			envoi_mail("nouvel_inscrit", "localhost@local.io");
				/*  */

			/* retour à la page des Bielles Meusiennes avec un message de réussite ou d'erreur */
			
			header('Location: http://localhost/site distant autorise/success.html');
			} catch (Exception $e) {
				/* effacer les données dans la bdd*/

				/* */
				header('Location: http://localhost/site distant autorise/error.html');
			}
			
		} catch (Exception $e) {		
			
			header('Location: http://localhost/site distant autorise/error.html');
		}
	} else {
		
		header('Location: http://localhost/site distant autorise/error.html');
	}
}

?>