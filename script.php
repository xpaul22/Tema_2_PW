<?php
// Conectare la baza de date
$servername = "localhost";
$username = "root";
$password = ""; // Lăsați gol dacă nu aveți parolă
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

// Obține datele din formular
$produs = $_POST['produs'];
$pret_buc = $_POST['pret_buc'];

// Interogare pentru a afla câte produse există cu același nume și preț pe bucată
$query = "SELECT NR_CRT, BUCATI, PRET_BUC FROM Table1 WHERE PRODUS = '$produs' AND PRET_BUC = '$pret_buc'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Produse gasite:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>NR_CRT</th><th>PRODUS</th><th>BUCATI</th><th>PRET_BUC</th><th>PRET_TOTAL</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $nr_crt = $row['NR_CRT'];
        $bucati = $row['BUCATI'];
        $pret_buc_db = $row['PRET_BUC'];
        $pret_total = $bucati * $pret_buc_db;

        echo "<tr><td>$nr_crt</td><td>$produs</td><td>$bucati</td><td>$pret_buc_db</td><td>$pret_total</td></tr>";
    }

    echo "</table>";
} else {
    echo "Nu există produse cu aceste caracteristici.";
}

// Închide conexiunea la baza de date
$conn->close();
?>
