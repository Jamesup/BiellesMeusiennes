<?php
require "../vendor/autoload.php";
include_once('../includes/common/functions.php');

use Core\Mailer\Mail;
use Core\Configure\Config;
use Core\Export\DataExporter;

$participants = Config::QueryBuilder()->findAll("Owners")->execute();

			$pdf = new DataExporter('test', 'pdf');
			$pdf->setPdfAttributes('l', 'A4', 'fr', 'default');
			$resultPdf = $pdf->save($participants);

$content_text = "voici du text non formaté \r\n et ici c'est une autre ligne";
$content_html = "<p>Voici du text qui <b> cette fois </b> est formaté</p>";

/*$content_text = "Bonjour " .$participant->firstname. " ".$participant->lastname.", \r\n nous avons bien pris en compte votre demande concernant le véhicule suivant : \r\n Marque : ".$participant->marque." \r\n Modèle : ".$participant->model."\r\n Immatriculation : ".$participant->imat."\r\n Date de mise en circulation : ".$participant->date_circu."\r\n Vous recevrez dans les prochains jours un email confirmant ou refusant votre inscription \r\n Cordialement. \r\n Pour plus d'infos : www.biellesmeusiennes.com \r\n L'équipe des Bielles Meusiennes.";
$content_html = file_get_contents('../includes/App/Views/mails/base_mail.html');
$content_html = mail_all_update($content_html, [
				["%firstname%", $participant->firstname],
				["%lastname%", $participant->lastname],
				["%marque%", $participant->marque],
				["%model%", $participant->model],
				["%immat%", $participant->imat],
				["%date_circu%", $participant->date_circu],
				["%message%", "nous avons bien pris en compte votre demande concernant le véhicule suivant :"]
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