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
$inscriptions = Config::QueryBuilder()->findAll("Owners")->contain('Vehicles')->execute();

  if(!isset($_SESSION)) { 
    session_start();
  }
  if (isset($_SESSION['id']) AND isset($_SESSION['username'])) {
    include_once('../includes/common/verif_security.php');
    $token = generer_token();
  }  

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<?php
include('../includes/common/head.php'); //contient le head.
?>

  <title>Informations des utilisateurs</title>
</head>
<header>
<?php 
include('cssmenu/topNavBar.php'); //contient le header.
?>
</header>

<body>

  <!--Style CSS perso-->
  <style type="text/css">

  h2
  {
    text-align: center;
  }

  th, td
  {
    text-align: center;
  }

  button
  {
    margin-left: 5px;
  }

  body
  {
    font-size: 1.7em;
  }

  </style>

  <!--FIN du style CSS perso-->

  <h2>Informations générales des utilisateurs</h2>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <div class="table-responsive">
          <table id="moTable" summary="Exemple d'affichage du tableau de visualisation des utilisateurs" class="table table-hover table-striped table-responsive table-condensed">
            <thead>
              <tr>                
                <th>NOM</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Date de Mise en Circulation</th>
                <th>Actions Administrateur</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach( $inscriptions as $inscription ): ?>
              <tr>                
                <td><?= $inscription->lastname ;?></td>
                <td><?= $inscription->firstname ;?></td>
                <td><?= $inscription->email ;?></td>
                <td><?= $inscription->marque ;?></td>
                <td><?= $inscription->model ;?></td>
                <td><?= $inscription->date_circu ;?></td>
                <td class="row">
                  <div class="col-xs-6">
                    <a href="inscrits_view.php?user=<?php echo $inscription->owner_id;?>" class="btn btn-default btn-md">Voir</a>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-success btn-md">Valider</button><button type="button" class="btn btn-warning btn-md">Refuser</button>
                  </div>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!--DataTable-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#moTable').dataTable( {
            "language": {
    "sProcessing":     "Traitement en cours...",
    "sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
    "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
    },
    "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
    }
}
        } );
    } );
</script>


</body>
</html>
