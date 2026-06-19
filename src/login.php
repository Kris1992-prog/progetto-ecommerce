<?php
session_start(); // Fondamentale: avvia la sessione per ricordare l'utente

$host = 'db';
$db   = 'ecommerce';
$user = 'root';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Cerchiamo l'utente nel DB
        $sql = "SELECT id, nome, password FROM utenti WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $utente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifichiamo se l'utente esiste E se la password coincide
        if ($utente && password_verify($password, $utente['password'])) {
            // Login riuscito!
            $_SESSION['user_id'] = $utente['id'];
            $_SESSION['user_name'] = $utente['nome'];
            
            echo "<h1>Benvenuto, " . htmlspecialchars($utente['nome']) . "!</h1>";
            echo '<a href="index.php">Vai al catalogo</a>';
        } else {
            echo "<h1>Errore:</h1> Email o password errate.";
            echo '<br><a href="login.html">Riprova</a>';
        }
    }
} catch (PDOException $e) {
    die("Errore di sistema: " . $e->getMessage());
}
?>