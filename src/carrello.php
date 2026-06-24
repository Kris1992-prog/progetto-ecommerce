<?php
//  La parte superiore (La logica va PRIMA di ogni altra cosa)
session_start();
require_once 'config.php';

// Se il carrello è vuoto, lo gestiamo subito
$carrello_vuoto = empty($_SESSION['carrello']);

if (!$carrello_vuoto) {
    // Prepariamo la query solo se serve
    $ids = $_SESSION['carrello'];
    $ids_unici = array_unique($ids);
    $placeholder = implode(',', array_fill(0, count($ids_unici), '?'));
    $query = "SELECT * FROM prodotti WHERE id IN ($placeholder)";
    $stmt = $conn->prepare($query);
    $tipi = str_repeat('i', count($ids_unici));
    $stmt->bind_param($tipi, ...$ids_unici);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Il mio Carrello</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <?php include 'menu.php'; ?>
    <h1>Il tuo Carrello</h1>
    <a href="catalogo.php">Torna al catalogo</a>
    <hr>

    <?php if ($carrello_vuoto): ?>
        <p>Il tuo carrello è vuoto.</p>
    <?php else: ?>
        
        <div class="product-grid"> 
            
            <?php 
            $totale = 0;
            while ($row = $result->fetch_assoc()): 
                $totale += $row['prezzo'];
            ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                    <p class="price">€ <?php echo htmlspecialchars($row['prezzo']); ?></p>
                    <a href="rimuovi.php?id=<?php echo $row['id']; ?>" style="color:red; font-size: 0.8em;">Rimuovi</a>
                </div>
            <?php endwhile; ?>

        </div> <h3>Totale complessivo: € <?php echo number_format($totale, 2); ?></h3>
        <a href="svuota.php" style="color:red; margin-top: 20px; display:block;">Svuota tutto il carrello</a>

    <?php endif; ?>

</body>
</html>