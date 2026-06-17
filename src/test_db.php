<?php
$host = 'db';
$db   = 'ecommerce';
$user = 'root';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->query("SELECT * FROM prodotti");
    $prodotti = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista Prodotti</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Elenco Prodotti</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Prezzo</th>
            <th>Stock</th>
        </tr>
        <?php foreach ($prodotti as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['nome']); ?></td>
            <td>€ <?php echo htmlspecialchars($row['prezzo']); ?></td>
            <td><?php echo htmlspecialchars($row['stock']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="form.html">Aggiungi nuovo prodotto</a>
</body>
</html>