<?php

require "../../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;
include_once($_SERVER['DOCUMENT_ROOT'].'/BiellesMeusiennes/BiellesMeusiennes/includes/common/mailing.php');


if ($_POST && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'validate':            
            echo  validate( $_POST['type'], $_POST['id']);
            break;
        case 'exportCsv':
            export($_POST['model']);
            break;
    }
} else {
    header('Location: ../../404.html');
    exit();
}

function validate ($type, $id) {
    $params = false;
    switch ($type) {
        case "valider":
            $message = ["message" =>  "Inscription valide"];
            $params1 = ['valid' => 1];
            $params2 = "validation";          
            break;
        case "refuser":
            $message = ["message" =>  "Inscription refuse"];
            $params1 = ['valid' => 2];
            $params2 = "refus";            
            break;
        case "supprimer":
            $message = ["message" =>  "Inscription supprimee"];
            break;
    }
    
    if ( $params1 ) {        
        $upd = Config::QueryBuilder()->update('exposants', ['id' => $id], $params1)->execute();
        envoi_mail ($params2, $id);
    }else {
        $upd = Config::QueryBuilder()->delete('exposants')->where(['id' => $id])->execute();        
    }
    if ($upd) {
        if (!$message) {
            $message = ["message" =>  "Une erreur est survenue merci de contacter un administrateur"];
        }
    }
    $response = json_encode($message);
    return  $response;
}

function export($model)
{
    $datas = Config::QueryBuilder()->findAll($model)->contain('Vehicles')->execute();
    $csv = new DataExporter('../../Output/export', 'csv');
    $csv->export($datas);
    return true;
}



