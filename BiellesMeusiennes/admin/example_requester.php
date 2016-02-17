<?php
require "../vendor/autoload.php";
use Core\Configure\Config;

/*
 *  Obligatoire
 *
 *  require "../vendor/autoload.php";        // Toujours require l'autoloader de composer afin de charger les classes nécessaires
 *  use Core\Configure\Config;               // Préciser que l'on va utiliser les classes du namespace Core\Configure\Config
 *
 */

/*
 *      FINDONE
 *
 *      Retrouver un enregistrement et un seul!
 *      Retourne l'enregistrement sous forme d'objet
 *
 *      Exemple d'utilisation :
 *      $owner = Config::QueryBuilder()->findOne('Owners')->where(['id' => 1])->execute();
 *
 *      Config::QueryBuilder()              // Appel et init. du requester
 *      findOne('nom de la table')          // findOne précise que l'on veut récupérer un seul objet
 *      where( tableau de conditions )      // tableau de parametre indexé par le nom du champ
 *      contain('nom de table')             // S'occupe de faire la liaison suivant nom du champ de la table jointe: tableParente_id
 *      execute();                          // fonction qui va lancer la requête
 *
 */


/*
 *      FIND ALL
 *
 *      Retrouver plusieurs enregistrement!
 *      Retourne les enregistrements sous forme de tableau d'objet
 *
 *      Exemple d'utilisation :
 *      $owners = Config::QueryBuilder()->findAll('Owners')->where(['newsletter' => 1])->execute();
 *      $owners = Config::QueryBuilder()->findAll('Owners')->execute();
 *
 *      Config::QueryBuilder()              // Appel et init. du requester
 *      findAll('nom de la table')          // findOne précise que l'on veut récupérer plusieurs résultat sous forme de tableau
 *      where( tableau de conditions )      // Optionnel: tableau de parametre indexé par le nom du champ et peut prendre un talbeau en valeur ['id' => [15, 19,20]]
 *      contain('nom de table')             // S'occupe de faire la liaison suivant nom du champ de la table jointe: tableParente_id
 *      execute();                          // fonction qui va lancer la requête
 *
 */


/*
 *      INSERT
 *
 *
 *      Inserer un enregistrement!
 *      Retourne true or false suivant l'insertion faite ou non
 *
 *      Exemple d'utilisation :
 *      $newOwner = Config::QueryBuilder()->save('Owners', $datas)->execute();
 *
 *      Config::QueryBuilder()                          // Appel et init. du requester
 *      save('nom de la table', [tableau de données])     // Le tableau de donnée doit être indexé par les champ à insérer
 *
 *      exemple:
 *
 *      $data = [
 *          'lastname' => 'Jc',
 *          'firstname' => 'Pires',
 *          '...' => '...'
 *      ];
 *
 *      execute();                                      // fonction qui va lancer la requête
 *
 */


/*
 *      UPDATE
 *
 *      Mettre à jour un enregistrement!
 *      Retourne true or false suivant l'update faite ou non
 *
 *      Exemple d'utilisation :
 *      $newOwner = Config::QueryBuilder()->update('Owners', ['id' => 1], ['lastname' => 'new'])->execute();
 *
 *      Config::QueryBuilder()                                                              // Appel et init. du requester
 *      update('nom de la table', [tableau de condition], [tableau de nouvelle valeur])     // Le tableau de nouvelle valeur doit être indexé par les champ à mettre à jour,
 *                                                                                             Le tableau de condition doit être indexé par les champ
 *      execute();                                                                          // fonction qui va lancer la requête
 *
 */

/*
 *      DELETE
 *
 *      Supprimer un enregistrement!
 *      Retourne true or false suivant si delete fait ou non
 *
 *      Exemple d'utilisation :
 *      $newOwner = Config::QueryBuilder()->delete('Owners')->where(['id' => [59,61]])->execute();
 *
 *      Config::QueryBuilder()                  // Appel et init. du requester
 *      delete('nom de la table')               // Nom de la table
 *      where([tableau de condition])           // tableau de parametre indexé par le nom du champ et peut prendre un talbeau en valeur ['id' => [15, 19,20]]
 *      execute();                              // fonction qui va lancer la requête
 *
 */


/*
 *      DELETE ALL
 *
 *      Vider une table!
 *      Retourne true or false suivant si delete fait ou non
 *
 *      Exemple d'utilisation :
 *      $newOwner = Config::QueryBuilder()->deleteAll('Owners')->execute();
 *
 *      Config::QueryBuilder()                  // Appel et init. du requester
 *      delete('nom de la table')               // Nom de la table à réinitialiser
 *      execute();                              // fonction qui va lancer la requête
 *
 */
