<?php
include('../includes/common/verif_security.php'); 

try {
    verif_origin_user();
    $token =  $_GET['token'];
} catch (Exception $e) {
   header('Location: http://localhost/BiellesMeusiennes/BiellesMeusiennes/admin/index.php?message=errortoken&token=' . $_GET['token'] );
    die();
}

require "../vendor/autoload.php";
use Core\Configure\Config;


$inscriptions = Config::QueryBuilder()->findAll("Owners")->contain('Vehicles')->execute();

//$inscriptions = Config::QueryBuilder()->findAll("Owners")->contain('Vehicles')->orderBy(['valid' =>'ASC'])->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Informations des utilisateurs</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="../assets/css/TopNavBarStyles.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>
    <!--Style CSS perso-->
<style type="text/css">

    h1 {
        text-align: center;
    }

    th, td {
        text-align: center;
    }

    button {
        margin-left: 5px;
    }

    body {
        font-size: 1.7em;
    }




</style>

<!--FIN du style CSS perso-->

    
    <div id='cssmenu' class="sticky">
        <ul>
           <li><a href='http://localhost/BiellesMeusiennes/BiellesMeusiennes/admin/liste.php?token=<?= $_GET['token']; ?>'>Home</a></li>
           <li><a href=''>Reset BDD</a></li>
           <li><a href='http://localhost/BiellesMeusiennes/BiellesMeusiennes/includes/admin/register_admin.php?token=<?= $_GET['token']; ?>'>Creer un compte</a></li>
           <li><a href='http://localhost/BiellesMeusiennes/BiellesMeusiennes/includes/admin/logout.php?token=<?= $_GET['token']; ?>'>Deconnexion</a></li>
        </ul>
    </div>
    


<h1>Informations générales des utilisateurs</h1>

<input type="hidden" value="<?php echo $_POST['token']?>">

<div class="container-fluid">
    <div id="alert" style="display:none;">
        <div class="alert"></div>
    </div>
    <div class="row" style="padding-bottom:50px;">
        <div class="col-xs-10 col-xs-offset-1 ">
            <div class="pull-right">
                <form action="actions/actions.php" method="POST">
                    <input name="action" value="exportCsv" type="hidden">
                    <input name="model" value="Owners" type="hidden">
                    <button id="btn-csv" type="submit" class="btn btn-primary">Export csv</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="table-responsive">
                <table id="moTable" summary="Exemple d'affichage du tableau de visualisation des utilisateurs"
                       class="table table-hover table-striped table-responsive table-condensed">
                    <thead>
                    <tr>

                        <th></th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Newsletter</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Immat.</th>
                        <th>Date de Mise en Circulation</th>
                        <th>Validé</th>
                        <th style="display:none;"></th>
                        <th>Actions Administrateur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($inscriptions as $inscription): ?>
                        <tr>
                            <?php if($inscription->valid == 0){
                                $color = "orange";
                                $text = "en attente";
                            } else if ($inscription->valid == 1){
                                $color = "green";
                                $text = "validé";
                            } else if($inscription->valid == 2){
                                $color ="red";
                                $text = "refusé";
                            }?>
                            <td><?= ($inscription->type) ? "Mme" : "Mr"; ?></td>
                            <td><?= $inscription->lastname; ?></td>
                            <td><?= $inscription->firstname; ?></td>
                            <td><?= $inscription->email; ?></td>
                            <td><?= ($inscription->newsletter) ? "<span style='color:green;'>Oui</span>" : "<span style='color:red;'>Non</span>"; ?></td>
                            <td><?= $inscription->marque; ?></td>
                            <td><?= $inscription->model; ?></td>
                            <td><?= $inscription->immat; ?></td>
                            <td><?= $inscription->date_circu; ?></td>
                            <td><span style="color:<?=$color ?>; width:0.3%;"><?= $text ?></span></td>
                            <td style="display:none;"><span style="visibility: hidden;"><?= $inscription->valid;?></span></td>
                            <td>
                                <span class="pull-left">
                                    <a href="view.php?user=<?= $inscription->owner_id; ?>&token=<?= $_GET['token'] ?>"
                                       class="btn btn-default btn-md">Voir</a>
                                    <?php if ($inscription->valid == 0): ?>
                                        <button type="button" class="btn btn-success btn-validate"
                                                data-id="<?= $inscription->owner_id; ?> ">Valider
                                        </button>
                                        <button type="button" class="btn btn-danger btn-refused"
                                                data-id="<?= $inscription->owner_id; ?>">Refuser
                                        </button>
                                    <?php elseif($inscription->valid == 1): ?>
                                        <button type="button" class="btn btn-danger btn-refused"
                                                data-id="<?= $inscription->owner_id; ?>">Refuser
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-success btn-validate"
                                                data-id="<?= $inscription->owner_id; ?>">Valider
                                        </button>
                                    <?php endif; ?>
                                </span>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--DataTable-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/topNavBarScript.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#moTable').dataTable({
           "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },

                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },
           "order": [[10, 'asc']]
        });
        $('.btn-validate').on('click', function (e) {
            e.preventDefault();
            var data = {
                action: "validate",
                type: "valider",
                id: $(this).data('id')
            };
            var alertWrapper = $('#alert');
            var alertContent = $('.alert');

            $.post('actions/actions.php', data)
                .done(function (result) {
                    var res = JSON.parse(result);
                    alertContent.addClass('alert-success').removeClass('alert-danger').html(res.message);
                    alertWrapper.fadeIn().delay(1000).fadeOut(400);
                    setTimeout(location.reload(), 6000);
                })
                .fail(function () {
                    alertContent.addClass('alert-danger').removeClass('alert-success').html('Une erreur est survenue lors de l\'action demandée');
                    alertWrapper.fadeIn().delay(1000).fadeOut(400);
                    setTimeout(location.reload(), 6000);
                })
        });
        $('.btn-refused').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.preventDefault();
            var data = {
                action: "validate",
                type: "refuser",
                id: $(this).data('id')
            };
            var alertWrapper = $('#alert');
            var alertContent = $('.alert');

            $.post('actions/actions.php', data)
                .done(function (result) {
                    var res = JSON.parse(result);
                    alertContent.addClass('alert-success').removeClass('alert-danger').html(res.message);
                    alertWrapper.fadeIn().delay(2000).fadeOut(400);
                    setTimeout(location.reload(), 2000);
                })
                .fail(function () {
                    alertContent.addClass('alert-danger').removeClass('alert-success').html('Une erreur est survenue lors de l\'action demandée');
                    alertWrapper.fadeIn().delay(2000).fadeOut(400);
                    setTimeout(location.reload(), 2000);
                })
        });
    });
</script>


</body>
</html>
