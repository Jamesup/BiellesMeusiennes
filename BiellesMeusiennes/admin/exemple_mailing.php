<?php
require "../vendor/autoload.php";

use Core\Mailer\Mail;


$content_text = "voici du text non formaté \r\n et ici c'est une autre ligne";
$content_html = "<p>Voici du text qui <b> cette fois </b> est formaté</p>";
$pjs = [
    [
        'path' => 'le/chemin/du/fichier.file',
        'name' => 'nom du fichier'
    ],
    [
        'path' => 'le/chemin/du/fichier2.file',
        'name' => 'nom du fichier2'
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