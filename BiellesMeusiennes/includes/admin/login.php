<?php

//Cette fonction doit être appelée avant tout code html
session_start();

include('../common/connexion.php'); 

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
if (!isset($_POST['username'])) //On est dans la page de formulaire
{
	echo '<form method="post" action="login.php">
	<fieldset>
	<legend>Connexion</legend>
	<p>
	<label for="username">Identifiant :</label><input name="username" type="text" id="username" /><br />
	<label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
	</p>
	</fieldset>
	<p><input type="submit" value="Connexion" /></p></form>
	<a href="../admin/register_admin.php">Creer un compte administrateur</a>
	 
	</div>
	</body>
	</html>';
}

else
{
    $message='';
    if (empty($_POST['username']) || empty($_POST['password']) ) //Oublie d'un champ
    {
        $message = '<p>une erreur s\'est produite pendant votre identification.
	Vous devez remplir tous les champs</p>
	<p>Cliquez <a href="./login.php">ici</a> pour revenir</p>';
    }
    else //On check le mot de passe
    {
		$bdd = connexionbdd();
        $query = $bdd->prepare('SELECT password, id, email, username
        FROM users WHERE username = :username');
        $query->bindValue(':username',$_POST['username'], PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();
	if ($data['password'] == md5($_POST['password'])) // Acces OK !
	{
	    $_SESSION['username'] = $data['username'];
	    $_SESSION['id'] = $data['id'];
	    $message = '<p>'.$data['username'].', 
			vous êtes maintenant connecté!</p>
			<p>Cliquez <a href="./index.php">ici</a> 
			</p>';  
	}
	else // Acces pas OK !
	{
	    $message = '<p>Une erreur s\'est produite 
	    pendant votre identification.<br /> Le mot de passe ou l/identifiant
            entré n\'est pas correcte.</p><p>Cliquez <a href="./login.php">ici</a> 
	    pour revenir à la page précédente
	    <br /><br />Cliquez <a href="./index.php">ici</a> 
	    pour revenir à la page d accueil</p>';
	}
    $query->CloseCursor();
    }
    echo $message.'</div></body></html>';

}
?>

