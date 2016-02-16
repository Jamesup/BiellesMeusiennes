
<?php

include('./includes/common/connexion.php');

//fonction qui enregistre l'inscription dans la bdd  /!\ IL MANQUE DES CHAMPS A AJOUTER PAR RAPPORT AU FORMULAIRE /!\
function ajouter_inscription($donneesOwners, $donneesVehicles) {

	$bdd = connexionbdd();

	/* On crée le nouveau propriétaire dans la bdd*/
	$requeteOwners = $bdd->prepare(
		'INSERT INTO owners (firstname, lastname, type, email, adress1, adress2, adress3, city, cp, cedex, country, club, is_banned, created) 
		VALUES (:firstname, :lastname, :type, :email, :adress1, :adress2, :adress3, :city, :cp, :cedex, :country, :club, false, NOW())');
	try {
		$requeteOwners->execute($donneesOwners);
	}
	catch (Exception $e) {
		throw $e;
	}

	/* On crée le nouveau véhicule lié au propriétaire précédement créé*/
	$donneesVehicles['owner_id'] = $bdd->lastInsertId();

	$requeteVehicles = $bdd->prepare(
		'INSERT INTO vehicles (owner_id, marque, model, serie, motorisation, model_info, date_circu, imat, infos, is_banned, created)
		VALUES (:owner_id, :marque, :model, :serie, :motorisation, :model_info, :date_circu, :imat, :infos, false, NOW())');

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

?>