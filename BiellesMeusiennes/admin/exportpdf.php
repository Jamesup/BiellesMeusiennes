<?php
require "../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;

$membres = Config::QueryBuilder()->findAll("Owners")->execute();
$pdf = new DataExporter('test', 'pdf');
$pdf->setPdfAttributes('l', 'A4', 'fr', 'default')->export($membres);
