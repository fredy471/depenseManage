<?php
//je veux detruie la session sans deturire ces donnees dans le loclal storage
session_start();
session_unset();
session_destroy();

header('location:login.php');
exit;

?>