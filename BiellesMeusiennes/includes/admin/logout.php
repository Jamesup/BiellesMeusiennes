<?php
session_start();

$_SESSION = [];
session_destroy();

header('Location: http://localhost/BiellesMeusiennes-1/BiellesMeusiennes/admin/');
?>