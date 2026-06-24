<?php
session_start();

// Prendiamo l'ID del prodotto passato nel link (es: rimuovi.php?id=1)
if (isset($_GET['id'])) {
    $id_da_rimuovere = $_GET['id'];

    // Cerchiamo dove si trova questo ID nell'array della sessione
    $chiave = array_search($id_da_rimuovere, $_SESSION['carrello']);

    // Se lo troviamo, lo rimuoviamo
    if ($chiave !== false) {
        unset($_SESSION['carrello'][$chiave]);
        
        // Riordiniamo l'array per evitare "buchi" negli indici
        $_SESSION['carrello'] = array_values($_SESSION['carrello']);
    }
}

// Torniamo al carrello
header("Location: carrello.php");
exit();
?>