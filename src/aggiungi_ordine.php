<?php
session_start();
require 'config.php';

// Controllo sessione
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Controllo arrivo dati
if (!isset($_POST['prodotto_id'])) {
    die("Errore: Nessun prodotto selezionato.");
}

try {
    // Connessione (assumendo che $host, $user, $pass siano nel tuo config.php)
    $pdo = new PDO("mysql:host=$host;dbname=ecommerce;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Prendo il prezzo attuale del prodotto
    $stmt = $pdo->prepare("SELECT prezzo FROM prodotti WHERE id = ?");
    $stmt->execute([$_POST['prodotto_id']]);
    $prodotto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prodotto) {
        die("Prodotto non trovato.");
    }

    $prezzo = $prodotto['prezzo'];
    $quantita = 1; 
    $totale = $prezzo * $quantita;

    // 2. Inizio transazione per salvare tutto insieme
    $pdo->beginTransaction();

    // 3. Inserimento Ordine (uso utente_id come da tua tabella)
    $stmt1 = $pdo->prepare("INSERT INTO ordini (utente_id, totale) VALUES (?, ?)");
    $stmt1->execute([$_SESSION['user_id'], $totale]);
    $id_ordine = $pdo->lastInsertId();

    // 4. Inserimento Dettaglio Ordine (uso quantita e prezzo_unitario come da tua tabella)
    $stmt2 = $pdo->prepare("INSERT INTO ordine_prodotti (ordine_id, prodotto_id, quantita, prezzo_unitario) VALUES (?, ?, ?, ?)");
    $stmt2->execute([$id_ordine, $_POST['prodotto_id'], $quantita, $prezzo]);

    // Salvo tutto
    $pdo->commit();
    
    echo "Ordine effettuato con successo! <a href='catalogo.php'>Torna al catalogo</a>";

} catch (PDOException $e) {
    if (isset($pdo)) $pdo->rollBack();
    die("Errore durante l'ordine: " . $e->getMessage());
}
?>