<?php
// connessione al database
// preparazione della query
// esecuzione della query
// usare i dati


$host = 'localhost';
$db   = 'esercizio s1-l3';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    die(); 
}

$stmt = $pdo->query('SELECT * FROM utenti');

// Verifica presenza utenti e scrittura su file
// if ($stmt->rowCount() > 0) {
//     $utenti = [];
//     while ($row = $stmt->fetch()) {
//         $utenti[] = $row;
//     }}

$utenti = $stmt->fetchAll();
    // Apertura del file 
    // $file_handle = fopen('utenti.csv','w');

    // foreach($utenti as $row) {
    //     // Scrittura su file
    //     fputcsv($file_handle, $row);
    // }
    // fclose($file_handle);

    $file_handle_delimitati = fopen('utenti_delimitati.csv', 'w');
    $file_handle_non_delimitati = fopen('utenti_non_delimitati.csv', 'w');

    //Scrittura dati utenti con campi delimitati
    foreach($utenti as $row) {
        fputcsv($file_handle_delimitati, $row);
    }

// Scrittura dati utenti senza campi delimitati
foreach ($utenti as $utente) {
    $line = implode("\t", $utente); 
    // Concatena i valori con il tabulatore come separatore
    fwrite($file_handle_non_delimitati, $line); 
    // Aggiunge un salto di riga
}

fclose($file_handle_delimitati);
fclose($file_handle_non_delimitati);



