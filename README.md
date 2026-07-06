# OP CARDS - E-commerce Platform

Piattaforma e-commerce sviluppata per la gestione e la vendita di una collezione privata di Trading Card Game (TCG). Il progetto mira a digitalizzare il processo di vendita, offrendo un'esperienza utente fluida con una gestione sicura delle transazioni e delle sessioni.

## 🚀 Funzionalità Principali
*   **Catalogo Dinamico:** Visualizzazione ottimizzata dei prodotti tramite database MySQL.
*   **Gestione Acquisti:** Carrello persistente basato su sessioni PHP (aggiunta, rimozione singola, svuotamento totale).
*   **Navigazione:** Menu dinamico con architettura modulare per una facile manutenzione.
*   **Checkout:** Calcolo automatico dei totali per una user experience immediata.

---

## 🛠️ Stack Tecnologico
*   **Backend:** PHP (con logica P.D.O. per la sicurezza)
*   **Database:** MySQL
*   **Infrastruttura:** Docker & Docker Compose
*   **Versionamento:** Git & GitHub

---

## ⚙️ Manuale Tecnico & DevOps

### 1. Infrastruttura (Docker)
L'ambiente è containerizzato per garantire isolamento e riproducibilità totale del sistema di produzione.

*   **Avvio:** `docker-compose up -d --build`
*   **Spegnimento:** `docker-compose down`

**Variabili d'Ambiente:**
Per motivi di sicurezza, le credenziali (host, user, pass) sono gestite tramite file `.env`.
*   *Configurazione richiesta:*
    ```text
    DB_HOST=db
    DB_USER=root
    DB_PASS=la_tua_password
    ```

### 2. Sicurezza & Backend (PHP/PDO)
Il codice è stato scritto seguendo standard di sicurezza per prevenire le vulnerabilità comuni (come SQL Injection).

*   **Connessione:** Utilizzo di PDO con gestione delle eccezioni (`PDOException`) per evitare l'esposizione di errori di sistema al client.
*   **Prevenzione SQL Injection:** Utilizzo rigoroso di "Prepared Statements" per ogni query al database:
    ```php
    $stmt = $pdo->prepare("INSERT INTO prodotti (nome, prezzo, stock) VALUES (:nome, :prezzo, :stock)");
    $stmt->execute([
        'nome' => trim($_POST['nome']),
        'prezzo' => (float)$_POST['prezzo'],
        'stock' => (int)$_POST['stock']
    ]);
    ```

---

## 📁 Gestione Database
Se riscontri l'Errore 1146 (Table doesn't exist), assicurati di inizializzare la tabella:

```sql
CREATE TABLE prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);