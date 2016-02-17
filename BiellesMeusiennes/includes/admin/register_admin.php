<?php

//Cette fonction doit être appelée avant tout code html
session_start();

include('../common/connexion.php'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
</head>
<?php


include('../common/header.php'); //contient le header.


//Attribution des variables de session

$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$username=(isset($_SESSION['username']))?$_SESSION['username']:'';

//On inclue les 2 pages restantes
include("../admin/functions.php");
include("../admin/constants.php");
?>

<?php



?>

<?php
if (empty($_POST['username'])) // Si on la variable est vide, on peut considérer qu'on est sur la page de formulaire
{
	echo '<h1>Enregistrement nouveau administrateur</h1>';
	echo '<form method="post" action="register_admin.php" enctype="multipart/form-data">
	<fieldset><legend>Identifiants</legend>
	<label for="username">* Identifiant :</label>  <input name="username" type="text" id="username" /> (l/identifiant doit contenir entre 3 et 15 caractères)<br />
	<label for="password">* Mot de Passe :</label><input type="password" name="password" id="password" /><br />
	<label for="confirm">* Confirmer le mot de passe :</label><input type="password" name="confirm" id="confirm" />
	</fieldset>
	<fieldset><legend>Contacts</legend>
	<label for="email">* Votre adresse Mail :</label><input type="text" name="email" id="email" /><br />
	</fieldset>
	
	<p>Les champs précédés d un * sont obligatoires</p>
	<p><input type="submit" value="S\'enregistrer" /></p></form>
	</div>
	</body>
	</html>';
	
	
} //Fin de la partie formulaire

else //On est dans le cas traitement
{
    $username_erreur1 = NULL;
    $username_erreur2 = NULL;
    $password_erreur = NULL;
    $email_erreur1 = NULL;
    $email_erreur2 = NULL;
    
?>
<?php

    //On récupère les variables
    $i = 0;
    $temps = time(); 
    $username=$_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm = md5($_POST['confirm']);
	
    //Vérification de l'identifiant
	$bdd = connexionbdd();
    $query=$bdd->prepare('SELECT COUNT(*) AS nbr FROM users WHERE username =:username');
    $query->bindValue(':username',$username, PDO::PARAM_STR);
    $query->execute();
    $username_free=($query->fetchColumn()==0)?1:0;
    $query->CloseCursor();
    if(!$username_free)
    {
        $username_erreur1 = "Votre Identifiant est déjà utilisé";
        $i++;
    }

    if (strlen($username) < 3 || strlen($username) > 15)
    {
        $username_erreur2 = "Votre identifiant est soit trop grand, soit trop petit";
        $i++;
    }

    //Vérification du mdp
    if ($password != $confirm || empty($confirm) || empty($password))
    {
        $password_erreur = "Votre mot de passe et votre confirmation diffèrent, ou sont vides";
        $i++;
    }
	  //Vérification de l'adresse email

    //Il faut que l'adresse email n'ait jamais été utilisée
    $query=$bdd->prepare('SELECT COUNT(*) AS nbr FROM users WHERE email =:email');
    $query->bindValue(':email',$email, PDO::PARAM_STR);
    $query->execute();
    $email_free=($query->fetchColumn()==0)?1:0;
    $query->CloseCursor();
    
    if(!$email_free)
    {
        $email_erreur1 = "Votre adresse email est déjà utilisée ";
        $i++;
    }
    //On vérifie la forme maintenant
    if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $email) || empty($email))
    {
        $email_erreur2 = "Votre adresse E-Mail n'a pas un format valide";
        $i++;
    }
   
?>
<?php
   if ($i==0)
   {
	echo'<h1>Enregistrement terminée</h1>';
        echo'<p> '.stripslashes(htmlspecialchars($_POST['username'])).' vous êtes enregistré</p>
	<p>Cliquez <a href="../../admin/index.php">ici</a> pour revenir à la page d accueil</p>';
	
        //La ligne suivante sera commentée plus bas
	
   
        $query=$bdd->prepare('INSERT INTO users (username, password, email)
        VALUES (:username, :password, :email)');
	$query->bindValue(':username', $username, PDO::PARAM_STR);
	$query->bindValue(':password', $password, PDO::PARAM_INT);
	$query->bindValue(':email', $email, PDO::PARAM_STR);

	
        $query->execute();

	//Et on définit les variables de sessions
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $bdd->lastInsertId(); ;
      
        $query->CloseCursor();
    }
    else
    {
        echo'<h1>Enregistrement interrompue</h1>';
        echo'<p>Une ou plusieurs erreurs se sont produites pendant l incription</p>';
        echo'<p>'.$i.' erreur(s)</p>';
        echo'<p>'.$username_erreur1.'</p>';
        echo'<p>'.$username_erreur2.'</p>';
        echo'<p>'.$password_erreur.'</p>';
        echo'<p>'.$email_erreur1.'</p>';
        echo'<p>'.$email_erreur2.'</p>';
 
       
        echo'<p>Cliquez <a href="../admin/register_admin.php">ici</a> pour recommencer</p>';
    }
}
?>
</div>

