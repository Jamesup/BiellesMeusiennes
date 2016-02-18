<?php
require "../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;


$membre = Config::QueryBuilder()->findAll("Owners")->execute();
//export en direct dans le navigateur
$pdf = new DataExporter('test', 'pdf');
$pdf->setPdfAttributes('l', 'A4', 'fr', 'default')->export($membre);
