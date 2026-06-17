<?php
// Credenziali (in futuro impareremo a nasconderle!)
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = 'ecommerce';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // 1. Validazione: Controlliamo che i dati esistano
    if (empty($_POST['nome']) || empty($_POST['prezzo'])) {
        die("Errore: Nome e Prezzo sono obbligatori! <a href='form.html'>Torna indietro</a>");
    }

    $nome = trim($_POST['nome']); // 'trim' toglie spazi inutili
    $prezzo = (float)$_POST['prezzo']; // Forza il numero ad essere decimale

    // 2. Inserimento
    $sql = "INSERT INTO prodotti (nome, prezzo, stock) VALUES (:nome, :prezzo, :stock)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => $nome, 
        'prezzo' => $prezzo, 
        'stock' => (int)$_POST['stock']
    ]);

    echo "Prodotto aggiunto correttamente! <a href='test_db.php'>Vedi lista</a>";

} catch (PDOException $e) {
    // Qui impareremo a gestire i log per monitorare l'app
    error_log($e->getMessage()); 
    echo "Si è verificato un errore tecnico. Riprova più tardi.";
}
?>