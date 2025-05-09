<?php
// Mostra errori per il debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Parametri per la connessione
$host = 'localhost';
$dbname = 'abbonamenti';
$username = 'root';
$password = ''; // se usi XAMPP di solito è vuota

try {
    // Connessione al database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

// Controllo che i dati siano arrivati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $eta = $_POST['eta'] ?? 0;
    $sesso = $_POST['sesso'] ?? '';

    if ($nome && $cognome && $eta && $sesso) {
        try {
            $sql = "INSERT INTO abbonamenti (nome, cognome, eta, sesso) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cognome, $eta, $sesso]);
            echo "Abbonamento effettuato con successo!";
        } catch (PDOException $e) {
            echo "Errore durante l'inserimento: " . $e->getMessage();
        }
    } else {
        echo "Dati incompleti. Per favore compila tutti i campi.";
    }
} else {
    echo "Form non inviato correttamente.";
}
