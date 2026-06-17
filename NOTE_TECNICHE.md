# MANUALE TECNICO: Stack Web, Docker & Git
*Documentazione ad uso professionale per il deployment e la manutenzione di applicazioni web.*

---

## 1. INFRASTRUTTURA (Docker)
**Obiettivo:** Creare ambienti isolati, riproducibili e sicuri.

### Docker Compose (docker-compose.yml)
Il cuore del progetto. Definisce le relazioni tra web server, database e tool di gestione.

- **Comando Avvio:** `docker-compose up -d --build`
  - *Perché:* Crea i container e applica le modifiche ai file di configurazione (`Dockerfile` o `yaml`).
- **Comando Spegnimento:** `docker-compose down`
  - *Perché:* Ferma i processi e libera le porte occupate.
- **Variabili d'Ambiente (Sicurezza):**
  - Si usano per passare credenziali (host, user, pass) al container senza scriverle nel codice.
  ```yaml
  environment:
    - DB_HOST=db
    - DB_USER=root
    - DB_PASS=password

     
# BACKEND & SICUREZZA (PHP/PDO)
 
 Obiettivo: Scrivere codice pulito, sicuro contro attacchi (SQL Injection) e portabile.

Connessione Dinamica (Senza Hardcoding)
Invece di scrivere la password nel file PHP, la leggiamo dal sistema.
   ---

    <?php
// Legge i parametri definiti nel docker-compose.yml
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = 'ecommerce';

try {
    // Connessione tramite PDO (Standard industriale per sicurezza)
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Logga l'errore lato server, mai mostrare al client
    error_log("Connection failed: " . $e->getMessage());
    die("Errore di sistema.");
}

# Inserimento Dati Sicuro (Prevenzione SQL Injection)

Non concatenare mai variabili direttamente nella stringa SQL. Usa i "Prepared Statements".
  
  ---

// Il placeholder :nome protegge da iniezioni malevole
$stmt = $pdo->prepare("INSERT INTO prodotti (nome, prezzo, stock) VALUES (:nome, :prezzo, :stock)");

// Esecuzione pulita dei dati
$stmt->execute([
    'nome'   => trim($_POST['nome']),
    'prezzo' => (float)$_POST['prezzo'],
    'stock'  => (int)$_POST['stock']
]);

 
 # DATABASE (SQL)
Obiettivo: Mantenere la struttura coerente.

---

CREATE TABLE prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

Troubleshooting:

Errore 1146 (Table doesn't exist): Il database è online ma non ha la tabella. Eseguire lo script SQL sopra.


---

# GitHub

# 1. Controlla lo stato dei file (ti dirà che il file README.md è 'untracked')
git status

# 2. Prepara il file per il salvataggio
git add README.md

# 3. Crea il "punto di salvataggio" (il commit)
git commit -m "docs: aggiunta documentazione tecnica al progetto"

# 4. Invia tutto su GitHub
git push -u origin main