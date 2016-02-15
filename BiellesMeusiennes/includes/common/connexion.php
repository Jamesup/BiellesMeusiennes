<?php


/* Création de la fonction pour la connexion à la base de données*/
function connexionbdd() {
	try	{		
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=bielles', 'root', '', $pdo_options);
		$bdd->query("SET NAMES 'utf8'");
		return ($bdd);		
	}
	catch (Exception $e) 
	{		
    	throw new Exception ('Erreur : ' . $e->getMessage()); 
	}	
}
?>
