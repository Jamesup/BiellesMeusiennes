<?php
require "../vendor/autoload.php";
use Core\Configure\Config;

$inscription = Config::QueryBuilder()->findOne("Owners")->contain('Vehicles')->where(['owners.id' => intval($_GET['user'])])->execute();
//var_dump($inscription); die();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Visualisation d'un utilisateur</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<body>

<style type="text/css">

h2
{
  text-align: center;
}
td
{
  width:60%;
}
button
{
  margin-left: 5%;
}

body
{
  font-size: 1.8em;
}
</style>

  <h2>Visualisation complète des informations d'une inscription</h2>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <div class="table-responsive">
          <table summary="Visualisation des informations d'un propriétaire" class="table table-hover table-responsive table-condensed table-striped">
                <thead>
                  <tr>
                      <th colspan="2" class="text-center">Propriétaire</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th scope="row">NOM</th>
                      <td><?= $inscription->lastname ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Prénom</th>
                      <td><?= $inscription->firstname ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Genre</th>
                      <td><?= ($inscription->type == 0) ? "Homme" : "Femme" ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Email</th>
                      <td><?= $inscription->email ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Adresse 1</th>
                      <td><?= $inscription->adress1 ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Adresse 2</th>
                      <td><?= $inscription->adress2 ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Adresse 3</th>
                      <td><?= $inscription->adress3 ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Ville</th>
                      <td><?= $inscription->city ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Code Postal</th>
                      <td><?= $inscription->cp ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Cedex</th>
                      <td><?= $inscription->cedex ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Pays</th>
                      <td><?= $inscription->country ;?></td>

                  </tr>
                  <tr>
                      <th scope="row">Club</th>
                      <td><?= $inscription->club ;?></td>

                  </tr>
                </tbody>
          </table>
        </div>
      </div>
    </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">
                <table summary="Visualisation des informations d'un véhicule" class="table table-hover table-responsive table-condensed table-striped">
                  <thead>
                      <tr>
                        <th colspan="2" class="text-center">Véhicule</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <th scope="row">Marque</th>
                          <td><?= $inscription->marque ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Modèle</th>
                          <td><?= $inscription->model ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Série</th>
                          <td><?= $inscription->serie ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Motorisation</th>
                          <td><?= $inscription->motorisation ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Informations complémentaires sur le modèle</th>
                          <td><?= $inscription->model_info ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Date de mise en circulation</th>
                          <td><?= $inscription->date_circu ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Immatriculation</th>
                          <td><?= $inscription->imat ;?></td>

                      </tr>
                      <tr>
                          <th scope="row">Information complémentaire sur le véhicule</th>
                          <td><?= $inscription->infos ;?></td>

                      </tr>
                </tbody>
              </table>
        </div>
      </div>
    </div>
    <div class="row">
          <div class="col-xs-4">

          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-info btn-lg">Editer</button>


            <button type="button" class="btn btn-success btn-lg">Valider</button>


            <button type="button" class="btn btn-warning btn-lg">Refuser</button>


            <button type="button" class="btn btn-danger btn-lg">Effacer</button>
          </div>
          <div class="col-xs-4">

          </div>
    </div>

  </div>






</body>
</html>
