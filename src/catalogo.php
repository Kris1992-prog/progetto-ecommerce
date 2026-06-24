<?php
session_start(); // <--- Per iniziare una sessione dell'utente

// Se il carrello non esiste ancora nel "quaderno", crealo vuoto
if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = []; 
}
// Controlliamo se è arrivato il comando "add" nell'URL
if (isset($_GET['add'])) {
    $id_prodotto = $_GET['add'];
    
    // Aggiungiamo l'ID al nostro array nel "quaderno"
    $_SESSION['carrello'][] = $id_prodotto;
    
    // Un piccolo trucco: ricarichiamo la pagina senza il "?add=X" nell'URL
    // per evitare di riaggiungere lo stesso prodotto se l'utente ricarica la pagina
    header("Location: catalogo.php");
    exit();
}

// Include la configurazione per connettersi al database
// Assicurati che config.php sia nella stessa cartella (src/)
require_once 'config.php';

//  Controllo: $conn viene da config.php. Se non esiste, lo blocchiamo subito
if (!isset($conn)) {
    die("Errore: La connessione al database ($conn) non è stata trovata. Controlla config.php");
}

//  Controlliamo se l'utente ha scritto qualcosa nella barra
$ricerca = $_GET['ricerca'] ?? ''; // Se non ha scritto nulla, $ricerca sarà vuota

//  Prepariamo la query in base alla situazione
if ($ricerca != '') {
    // Caso: L'utente sta cercando qualcosa
    $stmt = $conn->prepare("SELECT * FROM prodotti WHERE nome LIKE ?");
    
    // Prepariamo il termine con i simboli % (servono per trovare "contiene")
    $termine = "%" . $ricerca . "%"; 
    
    // "s" sta per Stringa (il tipo di dato che stiamo inviando)
    $stmt->bind_param("s", $termine);
} else {
    // Caso: L'utente non ha cercato nulla, mostriamo tutto
    $stmt = $conn->prepare("SELECT * FROM prodotti");
}

//  Eseguiamo (indipendentemente da quale query abbiamo scelto)
$stmt->execute();
$result = $stmt->get_result();

// Prepariamo l'array dei prodotti
$prodotti = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $prodotti[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<form method="GET" action="catalogo.php">
    <input type="text" name="ricerca" placeholder="Cerca un prodotto...">
    <button type="submit">Cerca</button>
</form>
<body>
    <?php include 'menu.php'; ?>
    <h1>Benvenuto, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Utente'; ?>!</h1>
    <a href="logout.php">Logout</a>
    
    <h2>Catalogo</h2>
    
    <div class="product-grid">
        <?php if (!empty($prodotti)): ?>
            <?php foreach ($prodotti as $row): ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                    <p class="price">€ <?php echo htmlspecialchars($row['prezzo']); ?></p>
                    <button class="btn-info">INFO</button>
                    <form action="aggiungi_ordine.php" method="POST">
                        <input type="hidden" name="prodotto_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <a href="catalogo.php?add=<?php echo $row['id']; ?>" class="btn-buy">COMPRA</a>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessun prodotto trovato.</p>
        <?php endif; ?>
    </div>
</body>
</html>