<?php

require "../../vendor/autoload.php";
use Core\Configure\Config;
use Core\Export\DataExporter;
include_once('./includes/common/mailing.php');


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
            $params = ['valid' => 1, 'action' => "validation"];          
            break;
        case "refuser":
            $message = ["message" =>  "Inscription refuse"];
            $params = ['valid' => 2, 'action' => "refus"];            
            break;
        case "supprimer":
            $message = ["message" =>  "Inscription supprimee"];
            break;
    }
    if ( $params ) {
        $upd = Config::QueryBuilder()->update('Owners', ['id' => $id], $params)->execute();
        envoi_mail($params['action'], "localhost.io", $id);
    }else {
        $upd = Config::QueryBuilder()->delete('Owners')->where(['id' => $id])->execute();
        $upd = Config::QueryBuilder()->delete('Vehicles')->where(['owner_id' => $id])->execute();
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



