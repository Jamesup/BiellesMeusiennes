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
$owners = Config::QueryBuilder()->findAll('Owners')->execute();
$csv = new DataExporter('Output/sortie', 'csv');
$csv->export($membres);
