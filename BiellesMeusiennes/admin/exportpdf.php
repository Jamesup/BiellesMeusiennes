<?php
require "../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;


$membre = Config::QueryBuilder()->findOne("Owners")->where(['id' =>18])->execute();
var_dump($membre);
die();



$pdf = new DataExporter('test', 'pdf');
$pdf->setPdfAttributes('l', 'A4', 'fr', 'default')->export($membre);
