<?php

require "./vendor/autoload.php";
include_once('./includes/common/functions.php');

use Core\Mailer\Mail;
use Core\Configure\Config;
use Core\Export\DataExporter;

function envoi_mail ($action, $mail , $owner_id) {

	switch ($action) {
		case "inscription" :

			$participant = Config::QueryBuilder()->findOne("Owners")->contain('Vehicles')->where(['owners.id' => $owner_id])->execute();		
			
			//=====Définition du sujet.			
			$subject = "RétroMeus'auto 2016 - préinscription";
			//=========
			
			$content_text = "Bonjour " .$participant->firstname. " ".$participant->lastname.", \r\n nous avons bien pris en compte votre demande concernant le véhicule suivant : \r\n Marque : ".$participant->marque." \r\n Modèle : ".$participant->model."\r\n Immatriculation : ".$participant->imat."\r\n Date de mise en circulation : ".$participant->date_circu."\r\n Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription \r\n Cordialement. \r\n Pour plus d'infos : www.biellesmeusiennes.com \r\n L'équipe des Bielles Meusiennes.";
			$content_html = file_get_contents('./includes/App/Views/mails/base_mail_inscription.html');
			$content_html = mail_all_update($content_html, [
				["%user_name%", $participant->firstname . " " . $participant->lastname],				
				["%marque%", $participant->marque],
				["%model%", $participant->model],
				["%immat%", $participant->imat],
				["%date_circu%", $participant->date_circu]
				]);
			$pjs= "";		
			 		
			break;
		case "nouvel_inscrit" :
			$participant = Config::QueryBuilder()->findOne("Owners")->contain('Vehicles')->where(['owners.id' => $owner_id])->execute();
			
			//=====Définition du sujet.			
			$subject = "RétroMeus'auto 2016 - Nouvel inscrit";
			//=========
			//=====Déclaration des messages au format texte et au format HTML.
			$content_text = "Un nouvel utilisateur s'est inscrit. Veuillez procéder à sa validation sur le site administratif";
			$content_html = file_get_contents('./includes/App/Views/mails/base_mail_inscription_admin.html');
			$content_html = mail_all_update($content_html, [
				["%marque%", $participant->marque],
				["%model%", $participant->model],
				["%immat%", $participant->imat],
				["%date_circu%", $participant->date_circu],
				["%user_name%", "Admin"],
				["%firstname%", $participant->firstname],
				["%lastname%", $participant->lastname]
				]);
			//==========			
			$pjs= "";
			break;

		/* autres cas ... */
		case "confirmation" :

			$participant = Config::QueryBuilder()->findOne("Owners")->contain('Vehicles')->where(['owners.id' => $owner_id])->execute();

			$pdf = new DataExporter('test', 'pdf');
			$pdf->setPdfAttributes('l', 'A4', 'fr', 'fiche_auto');
			$resultPdf = $pdf->save([$participant]);

			$pjs = [
			    [
			        'path' => $resultPdf,
			        'name' => $pdf->filename.'.pdf'
			    ]
			];	

			//=====Définition du sujet.			
			$subject = "Validation de votre inscription à l'évênement des Bielles Meusiennes";
			//=========
			
			$content_text = "Bonjour " .$participant->firstname. " ".$participant->lastname.", \r\n Félicitation ! \r\n Le véhicule suivant est inscrit sur le site des Bielles Meusiennes: \r\n Marque : ".$participant->marque." \r\n Modèle : ".$participant->model."\r\n Immatriculation : ".$participant->imat."\r\n Date de mise en circulation : ".$participant->date_circu." \r\n Vous trouverez joint à ce mail deux documents : \r\n   - le premier est à afficher sur le pare-brise du véhicule lors de la manifestation. \r\n   - le second est à donner aux bénévoles présents à l'entrée du site. \r\n Enfin, pour retirer une plaque rallye, veuillez vous présenter à l'espace spécifique sur le site muni de cet email. \r\n Au plaisir de vous retrouver lors de RetroMeuse' Auto 2016 ! \r\n Pour plus d'infos : www.biellesmeusiennes.com \r\n L'équipe des Bielles Meusiennes.";
			$content_html = file_get_contents('./includes/App/Views/mails/base_mail_confirmation.html');
			$content_html = mail_all_update($content_html, [
				["%user_name%", $participant->firstname . " " . $participant->lastname],				
				["%marque%", $participant->marque],
				["%model%", $participant->model],
				["%immat%", $participant->imat],
				["%date_circu%", $participant->date_circu]
				]);
			//==========	
			break;
		default : 
			throw new Exception ("error");
			break;
	}	
	
	$receiver_mail = $mail;
	$receiver_name = $participant->firstname . " " . $participant->lastname;	

	$mail = new Mail();
	try {
		$mail->send($receiver_mail, $receiver_name, $subject, $content_text, $content_html, $pjs); //pjs est optionnel
	} catch (Exception $e) {
		throw $e;
	}
}

?>
