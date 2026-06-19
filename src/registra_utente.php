<?php

require 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        // HASH DELLA PASSWORD: fondamentale per la sicurezza
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Prepariamo la query (evitiamo SQL Injection)
        $sql = "INSERT INTO utenti (nome, email, password) VALUES (:nome, :email, :password)";
        $stmt = $pdo->prepare($sql);
        
        // Eseguiamo
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'password' => $password
        ]);

        echo "<h1>Registrazione avvenuta con successo!</h1>";
        echo '<a href="registrazione.html">Torna indietro</a>';
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        die("<h1>Errore:</h1> Questa email è già registrata.");
    }
    die("<h1>Errore di sistema:</h1> " . $e->getMessage());
}
?>