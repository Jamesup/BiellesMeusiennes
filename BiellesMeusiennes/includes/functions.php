

<?php
/* Création de la fonction pour la connexion à la base de données*/
function connexionbdd()
{  
    try
    {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=bielles', 'root', '', $pdo_options);
        $bdd->query("SET NAMES 'utf8'");
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
}

<?php
//fonction qui enregistre l'inscription dans la bdd  /!\ IL MANQUE DES CHAMPS A AJOUTER PAR RAPPORT AU FORMULAIRE /!\
function ajouter_inscription($user, $mdp, $mail, $hash_validation) {

	$pdo = PDO2::getInstance();

	$requete = $pdo->prepare("INSERT INTO users SET
		nom_utilisateur = :nom_utilisateur,
		adresse_email = :adresse_email,
		hash_validation = :hash_validation,
		date_inscription = NOW()");

	$requete->bindValue(':nom_utilisateur', $user);
	$requete->bindValue(':mot_de_passe',    $mdp);
	$requete->bindValue(':adresse_email',   $mail);
	$requete->bindValue(':hash_validation', $hash_validation);

	if ($requete->execute()) {
	
		return $pdo->lastInsertId();
	}
	return $requete->errorInfo();
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