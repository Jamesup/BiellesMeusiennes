<?php
include('includes/common/verif_security.php');

/* Création de la fonction pour la connexion à la base de données*/
function connexionbdd() {	
	
	verif_origin_user();
	try	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=bielles', 'root', '', $pdo_options);
		$bdd->query("SET NAMES 'utf8'");
		return ($bdd);		
	}
	catch (Exception $e) 
	{		
    	die('Erreur : ' . $e->getMessage()); 
	}
	
}
?>
