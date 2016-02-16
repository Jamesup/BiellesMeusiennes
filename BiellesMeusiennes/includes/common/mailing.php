<?php
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
			$message_html = "
				<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
				<html xmlns:v=\"urn:schemas-microsoft-com:vml\">
					<head>
    				<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
    				<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0; maximum-scale=1.0;\">
    				<link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>				
				</head>
				<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">

				<table bgcolor=\"#c6dee7\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    				<tbody>
    					<tr>   						
    						<td bgcolor=\"#c6dee7\" valign=\"top\">
      						<!--[if gte mso 9]>
      							<v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"mso-width-percent:1000;\">
        						<v:fill type=\"tile\" src=\"http://hpics.li/17c220e\" color=\"#c6dee7\" />
        						<v:textbox style=\"mso-fit-shape-to-text:true\" inset=\"0,0,0,0\">
      						<![endif]-->
      						<div>
      							<table align=\"center\" width=\"590\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    								<tbody>
    									<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>
    									<tr>
    										<td align=\"center\" style=\"text-align: center;\">
    											<a href=\"www.biellesmeusiennes.com\"><img src=\"https://image.jimcdn.com/app/cms/image/transf/dimension=950x10000:format=png/path/sd11703028ab4756b/image/ieeaadee850038c1f/version/1417873457/image.png\" width=\"950\" border=\"0\" alt=\bannière Bielles Meusiennes\"></a>
    										</td>
    									</tr>
    									<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>
    									<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; font-size: 40px; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Bonjour ".$donneesOwner['firstname']. " ".$donneesOwner['name'].",</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>  					
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">nous avons bien pris en compte votre demande concernant le véhicule suivant :</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Marque : ".$donneesVehicle['marque']."</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Modèle : ".$donneesVehicle['model']."</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Immatriculation : ".$donneesVehicle['imat']."</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Date de mise en circulation : ".$donneesVehicle['date_circu']."</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription.</td>    						
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Cordialement</td>
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>    					
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">Pour plus d'infos : <a href=\"www.biellesmeusiennes.com\">Bielles Meusiennes</a></td>
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr> 
				    					<tr>
				    						<td style=\"font-family: 'Playfair Display', Helvetica, sans-serif; color: #5643C2; mso-line-height-rule: exactlty; line-height: 28px; \">L'équipe des Bielles Meusiennes</td>
				    					</tr>
				    					<tr>
    										<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\">
    											&nbsp;
    										</td>
    									</tr>    		
				    				</tbody>
    							</table>
      					    </div>
      							<!--[if gte mso 9]>
							        </v:textbox>
							    	</v:rect>
							  	<![endif]-->
							</td>
    					</tr>
    									
    				</tbody>
				</table>

				</html>
				";
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
