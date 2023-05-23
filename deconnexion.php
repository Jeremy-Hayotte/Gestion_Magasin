<?php
session_start();

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Redirection vers la page de connexion ou autre page appropriée
header('Location: login.php');
exit();
?>
