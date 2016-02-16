<?php
include_once('./includes/common/mailing.php');

envoi_mail("inscription", "localhost@local.io", [
  'nom' => "Hindenoch",
  'prénom' => "Jérémy",
  "marque" => "Opel",
  'model' => "Corsa",
  'imat' => "12-xa-56",
  'date_circu' => "01/08/1956"
   ]);  
?>