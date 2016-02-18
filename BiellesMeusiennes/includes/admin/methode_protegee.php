<?php
	session_start();
	include_once('../../includes/common/verif_security.php');

	try {
		verif_origin_user ();
		echo "on continue";
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
?>