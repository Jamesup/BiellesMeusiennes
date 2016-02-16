<?php

include_once('./includes/common/functions.php');

function envoi_mail ($contenu, $mail , $donneesOwner, $donneesVehicle) {

	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}

	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	$boundary_alt = "-----=".md5(rand());
	//==========

	//=====Création du header de l'e-mail
	$header = "From: <adminEnvoiBiellesMeusiennes@localhost.io>".$passage_ligne;	
	$header .= "MIME-Version: 1.0".$passage_ligne;
	//==========

	switch ($contenu) {
		case "inscription" :		
			$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;	

			//=====Définition du sujet.			
			$sujet = '=?utf-8?B?'.base64_encode("RétroMeus'auto 2016 - préinscription").'?=';
			//=========
			//=====Déclaration des messages au format texte et au format HTML.
			$message_txt = "Bonjour " .$donneesOwner['firstname']. " ".$donneesOwner['name'].",".$passage_ligne."nous avons bien pris en compte votre demande concernant le véhicule suivant :".$passage_ligne."Marque : ".$donneesVehicle['marque'].$passage_ligne."Modèle : ".$donneesVehicle['model'].$passage_ligne."Immatriculation : ".$donneesVehicle['imat'].$passage_ligne."Date de mise en circulation : ".$donneesVehicle['date_circu'].$passage_ligne."Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription.".$passage_ligne."Cordialement.".$passage_ligne."Pour plus d'infos : www.biellesmeusiennes.com".$passage_ligne."L'équipe des Bielles Meusiennes.";
			$message_html = file_get_contents('././includes/App/Views/mails/inscription.html');
			$message_html = mail_all_update($message_html, [
				["%firstname%", $donneesOwner['firstname']],
				["%name%", $donneesOwner['name']],
				["%marque%", $donneesVehicle['marque']],
				["%model%", $donneesVehicle['model']],
				["%immat%", $donneesVehicle['imat']],
				["%date_circu%", $donneesVehicle['date_circu']]
				]
				);
			//==========
			//=====Création du message.
			$message = $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format texte.
			$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_txt.$passage_ligne;
			//==========
			$message.= $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format HTML
			$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_html.$passage_ligne;
			//==========
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			//==========
			 		
			break;
		case "nouvel_inscrit" :
			$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

			//=====Définition du sujet.			
			$sujet = '=?utf-8?B?'.base64_encode("Nouvel inscrit à l'événement des Bielles Meusiennes").'?=';
			//=========
			//=====Déclaration des messages au format texte et au format HTML.
			$message_txt = "Un nouvel utilisateur s'est inscrit. Veuillez procéder à sa validation sur le site administratif";
			$message_html = "<html><head></head><body><b>Un nouvel utilisateur s'est inscrit</b>, Veuillez procéder à sa validation sur le <a href=\"\">site administratif</a>.</body></html>";
			//==========

			//=====Création du message.
			$message = $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format texte.
			$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_txt.$passage_ligne;
			//==========
			$message.= $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format HTML
			$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_html.$passage_ligne;
			//==========
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			//==========
			break;

		/* autres cas ... */
		case "confirmation" : 

			$header .= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

			//=====Définition du sujet.			
			$sujet = '=?utf-8?B?'.base64_encode("Validation de votre inscription à l'évênement des Bielles Meusiennes").'?=';
			//=========
			//=====Déclaration des messages au format texte et au format HTML.
			$message_txt = "Votre inscription a été validée. Veuillez recevoir en pièce jointe votre fiche auto à placer sur le pare brise de votre véhicule lors de l'événement";
			$message_html = "<html><head></head><body><b>Votre inscription a été validée.</b>, Veuillez recevoir en pièce jointe votre fiche auto à placer sur le pare brise de votre véhicule lors de l'événement.</body></html>";
			//==========

			//==========Lecture et mise en forme de la pièce jointe.
			$fichier   = fopen("././assets/doc/test.pdf", "r");   
			$attachement = fread($fichier, filesize("././assets/doc/test.pdf")); 
			$attachement = chunk_split(base64_encode($attachement));
			fclose($fichier); 
			//==========

			//=====Création du message.
			$message = $passage_ligne."--".$boundary.$passage_ligne;			
			$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
			$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
			//=====Ajout du message au format texte.	
			$message.= "Content-Type: text/plain; charset=\UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_txt.$passage_ligne;
			//==========

			$message.=$passage_ligne."--".$boundary_alt.$passage_ligne;
					
			//=====Ajout du message au format HTML
			$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_html.$passage_ligne;
			//==========

			//On erme la boundery alternative
			$message_txt.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
			//==========

			$message.= $passage_ligne."--".$boundary.$passage_ligne;
			
			//==========Ajout de la pièce jointe
			$message.= "Content-Type: application/pdf; name=\"test.pdf\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
			$message.= "Content-Disposition: attachement; filename=\"test.pdf\"".$passage_ligne;
			$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

			break;
		default : 
			throw new Exception ("error");
			break;
	}	

	//=====Envoi de l'e-mail.
	mail($mail, $sujet, $message, $header);
	//==========


}

?>
