<?php
include('../includes/common/verif_security.php'); 

try {
    verif_origin_user();
} catch (Exception $e) {
   header('Location: http://localhost/BiellesMeusiennes/BiellesMeusiennes/admin/index.php?message=errortoken&token=' . $_GET['token'] );
    die();
}

require "../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;


$membre = Config::QueryBuilder()->findAll("exposants")->execute();
//export en direct dans le navigateur
$pdf = new DataExporter('test', 'pdf');
$pdf->setPdfAttributes('l', 'A4', 'fr', 'default')->export($membre);
