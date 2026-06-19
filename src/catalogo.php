<?php
session_start(); // Avviamo la sessione per controllare chi sei

require 'config.php'; // Carica le variabili da questo file


// 1. Controllo di sicurezza: se non sei loggato, ti rimando al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->query("SELECT * FROM prodotti");
    $prodotti = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo Prodotti</title>
</head>
<body>
    <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <a href="logout.php">Logout</a> <h2>Catalogo</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Prezzo</th>
            <th>Azione</th>
        </tr>
        <?php foreach ($prodotti as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nome']); ?></td>
            <td>€ <?php echo htmlspecialchars($row['prezzo']); ?></td>
            <td>
                <button>Acquista</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>