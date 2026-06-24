<?php
session_start();

// Svuotiamo l'array della sessione
$_SESSION['carrello'] = []; 

// Torniamo al carrello
header("Location: carrello.php");
exit();
?>