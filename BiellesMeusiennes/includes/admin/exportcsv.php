<?php
require "../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;

$membres = Config::QueryBuilder()->findAll("Owners")->execute();
$csv = new DataExporter('Output/sortie', 'csv');
$csv->export($membres);
