<?php
// 1. Dobbiamo riprendere la sessione esistente per poterla distruggere
session_start();

// 2. Svuotiamo l'array delle sessioni (rimuoviamo tutti i dati)
$_SESSION = array();

// 3. Se vogliamo essere super sicuri, eliminiamo anche il cookie di sessione dal browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Distruggiamo la sessione sul server
session_destroy();

// 5. Reindirizziamo l'utente alla pagina di login (o alla home)
header("Location: login.html");
exit;
?>