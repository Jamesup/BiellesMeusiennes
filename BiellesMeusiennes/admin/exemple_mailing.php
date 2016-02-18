<?php
require "../vendor/autoload.php";

use Core\Mailer\Mail;
use Core\Configure\Config;
use Core\Export\DataExporter;

$participants = Config::QueryBuilder()->findAll("Owners")->execute();

$pdf = new DataExporter('test', 'pdf');
$pdf->setPdfAttributes('l', 'A4', 'fr', 'default');
$resultPdf = $pdf->save($participants);

$content_text = "voici du text non formaté \r\n et ici c'est une autre ligne";
$content_html = "<p>Voici du text qui <b> cette fois </b> est formaté</p>";

/*$content_txt = "Bonjour " .$participants['firstname']. " ".$donneesOwner['lastname'].",".$passage_ligne."nous avons bien pris en compte votre demande concernant le véhicule suivant :".$passage_ligne."Marque : ".$donneesVehicle['marque'].$passage_ligne."Modèle : ".$donneesVehicle['model'].$passage_ligne."Immatriculation : ".$donneesVehicle['imat'].$passage_ligne."Date de mise en circulation : ".$donneesVehicle['date_circu'].$passage_ligne."Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription.".$passage_ligne."Cordialement.".$passage_ligne."Pour plus d'infos : www.biellesmeusiennes.com".$passage_ligne."L'équipe des Bielles Meusiennes.";
$content_html = file_get_contents('././includes/App/Views/mails/base_mail.html');
$content_html = mail_all_update($content_html, [
				["%firstname%", $donneesOwner['firstname']],
				["%lastname%", $donneesOwner['lastname']],
				["%marque%", $donneesVehicle['marque']],
				["%model%", $donneesVehicle['model']],
				["%immat%", $donneesVehicle['imat']],
				["%date_circu%", $donneesVehicle['date_circu']],
				["%message%", "Bonjour " .$donneesOwner['firstname']. " ".$donneesOwner['lastname'].",\r\n nous avons bien pris en compte votre demande concernant le véhicule suivant : \r\n Marque : ".$donneesVehicle['marque']."\r\n Modèle : ".$donneesVehicle['model']."\r\n Immatriculation : ".$donneesVehicle['imat']."\r\n Date de mise en circulation : ".$donneesVehicle['date_circu']."\r\n Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription.\r\nCordialement.\r\nPour plus d'infos : www.biellesmeusiennes.com.\r\nL'équipe des Bielles Meusiennes."]
				]
				);
*/

$pjs = [
    [
        'path' => $resultPdf,
        'name' => $pdf->filename.'.pdf'
    ]
];

$receiver_mail = 'djyss@live.fr';
$receiver_name = "Jc Pires";
$subject = "Envoi de mail test";

$mail = new Mail();
$res = $mail->send($receiver_mail, $receiver_name, $subject, $content_text, $content_html, $pjs); //pjs est optionnel
if ($res === true) {
    echo "Envoyé";
} else {
    echo $res;
}