<?php
require "../vendor/autoload.php";
use Core\Configure\Config;
$owners = Config::QueryBuilder()->findAll('Owners')->execute();
$csv = new DataExporter('Output/sortie', 'csv');
$csv->export($membres);
