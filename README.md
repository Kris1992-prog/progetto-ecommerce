# OP CARDS - E-commerce Platform

Piattaforma e-commerce full-stack dedicata alla gestione e alla vendita di una collezione privata di Trading Card Game (TCG). Il progetto è stato concepito per unire funzionalità di vendita (catalogo, carrello, gestione stock) con un'architettura backend robusta e sicura.

## 🚀 Panoramica del Progetto
L'obiettivo è digitalizzare il processo di vendita delle carte collezionabili, offrendo un'esperienza utente fluida e un'infrastruttura di backend professionale basata su standard di sicurezza moderni.

## 🛠️ Stack Tecnologico
*   **Backend:** PHP (con logica P.D.O. per la sicurezza)
*   **Database:** MySQL
*   **Infrastruttura (DevOps):** Docker, Docker Compose, Nginx, AWS EC2 (Ubuntu)
*   **Tooling:** WinSCP (file transfer), SSH, Figma (design)
*   **Versionamento:** Git & GitHub

---

## ⚙️ Manuale Tecnico & DevOps

### 1. Infrastruttura Cloud (AWS & Docker)
Il progetto è ospitato su un'istanza **AWS EC2 (Ubuntu)**, configurata per garantire scalabilità e isolamento dei servizi.

*   **Deployment:** Utilizzo di **WinSCP** per il trasferimento sicuro dei file e configurazione di **Nginx** come reverse proxy.
*   **Containerizzazione:** L'intero ambiente è gestito tramite **Docker Compose** per garantire coerenza tra ambiente di sviluppo locale e server di produzione.

**Comandi per l'amministrazione:**
*   Avvio servizi: `docker-compose up -d --build`
*   Spegnimento servizi: `docker-compose down`

**Gestione Variabili d'Ambiente:**
Per motivi di sicurezza, le credenziali sono gestite esternamente tramite file `.env`:
```text
DB_HOST=db
DB_USER=root
DB_PASS=la_tua_password

# Backend & Sicurezza (PHP/PDO)
## Il codice è scritto adottando le best practice per prevenire le vulnerabilità comuni (es. SQL Injection).
### Sicurezza DB: Utilizzo rigoroso di "Prepared Statements" per ogni operazione:

$stmt = $pdo->prepare("INSERT INTO prodotti (nome, prezzo, stock) VALUES (:nome, :prezzo, :stock)");
$stmt->execute([
    'nome' => trim($_POST['nome']),
    'prezzo' => (float)$_POST['prezzo'],
    'stock' => (int)$_POST['stock']
]);

.

# 📁 Database Schema
## Per inizializzare il catalogo prodotti, utilizzare il seguente schema SQL:

CREATE TABLE prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);


Contatti

Progetto sviluppato da: Cristiano Ragusa

LinkedIn: www.linkedin.com/in/kris-webdev