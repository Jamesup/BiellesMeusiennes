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

$exposants = Config::QueryBuilder()->findAll('Exposants')->execute();

$csv = new DataExporter('Output/sortie', 'csv');

$titles = [
    "id"=> "id",
    "firstname"=> "Prenom",
    "lastname"=> "Nom",
    "email"=> "Email",
    "city"=> "Ville",
    "cp"=> "CP",
    "country"=> "Pays",
    "newsletter"=> "Newsletter",
    "club"=> "Club",
    "marque" => "Marque",
    "model" => "Model",
    "type" => "Type",
    "motorisation" => "Motorisation",
    "immat" => "Immatriculation",
    "date_circu" => "Date 1ere circulation",
    "infos" => "Infos comp.",
    "concours1" => "Claude Lorrenzini",
    "concours2" => "Coupe-Cabriolet",
    "concours3" => "Jeune -25 ans",
    "valid"=> "Valide"
];

array_unshift($exposants, $titles);
$csv->export($exposants);
