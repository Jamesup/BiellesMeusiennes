<?php
require $_SERVER['DOCUMENT_ROOT'].'/BiellesMeusiennes/BiellesMeusiennes/vendor/autoload.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/BiellesMeusiennes/BiellesMeusiennes/includes/common/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/BiellesMeusiennes/BiellesMeusiennes/includes/common/mailing.php');

use Core\Mailer\Mail;
use Core\Configure\Config;
use Core\Export\DataExporter;

envoi_mail ("inscription", "adresse_mail_inscrit@localhost.io", 83);
envoi_mail ("nouvel_inscrit", "mail_admin@localhost.io", 83);
envoi_mail ("validation", "adresse_mail_inscrit@localhost.io", 83);
envoi_mail ("refus", "adresse_mail_inscrit@localhost.io", 83);