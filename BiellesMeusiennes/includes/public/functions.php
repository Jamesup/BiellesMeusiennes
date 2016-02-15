
<?php

include('./includes/common/connexion.php'); 

//fonction qui enregistre l'inscription dans la bdd  /!\ IL MANQUE DES CHAMPS A AJOUTER PAR RAPPORT AU FORMULAIRE /!\
function ajouter_inscription($donneesOwners, $donneesVehicles) {

	$bdd = connexionbdd();


	/* On crée le nouveau propriétaire dans la bdd*/
	$requeteOwners = $bdd->prepare(
		'INSERT INTO owners (firstname, lastname, type, email, adress1, adress2, adress3, city, cp, cedex, country, is_banned, created) 
		VALUES (:firstname, :lastname, :type, :email, :adress1, :adress2, :adress3, :city, :cp, :cedex, :country, false, NOW())');

	try {
		$requeteOwners->execute($donneesOwners);
	}
	catch (Exception $e) {
		throw $e;
	}


	/* On crée le nouveau véhicule lié au propriétaire précédement créé*/
	$donneesVehicles['owner_id'] = $bdd->lastInsertId();

	$requeteVehicles = $bdd->prepare(
		'INSERT INTO vehicles (owner_id, marque, model, model_info, date_circu, imat, infos, is_banned, created) 
		VALUES (:owner_id, :marque, :model, :model_info, :date_circu, :imat, :infos, false, NOW())');

	try {	
		$requeteVehicles->execute($donneesVehicles);
	}
	catch (Exception $e) {
		/* En cas d'erreur, on efface le propriétaire de la bdd pour retrouver l'état initial de la bdd avant inscription*/
		$requeteDelete = $bdd->prepare(
		'DELETE FROM owners WHERE id = :owner_id');
		$requeteDelete->execute(['owner_id' => $donneesVehicles['owner_id']]);
		throw $e;
	} 
}


//Fonction Validation à l'envoie du formulaire d'inscription
function inscription_mail($mail, $user)//à rejouter dans les () ce que l'on aura besoin pour le mail
{

	$to = $mail;
	$subject = 'Inscription à l\'évènement des Bielles Meusiennes '.$user;
	
	$message = '<html>
					<head>
						<title></title>
					</head>
					
					<body>
						
					</body>
				</html>';
				
				
				//headers principaux.
				
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";


if($mail) return true;
return false;
}


//Fonction Validation de l'inscription par l'admin
function validation_inscription_mail($mail, $user)//à rejouter dans les () ce que l'on aura besoin pour le mail
{

	$to = $mail;
	$subject = 'Inscription validée à l\'évènement des Bielles Meusiennes '.$user;
	
	$message = '<html>
					<head>
						<title></title>
					</head>
					
					<body>
						
					</body>
				</html>';
				
				
				//headers principaux.
				
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";


if($mail) return true;
return false;
}


//Fonction Refus de l'inscription par l'admin
function refus_inscription_mail($mail, $user)//à rejouter dans les () ce que l'on aura besoin pour le mail
{

	$to = $mail;
	$subject = 'Inscription refusée à l\'évènement des Bielles Meusiennes '.$user;
	
	$message = '<html>
					<head>
						<title></title>
					</head>
					
					<body>
						
					</body>
				</html>';
				
				
				//headers principaux.
				
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";


if($mail) return true;
return false;
}
?>