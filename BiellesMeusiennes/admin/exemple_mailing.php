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