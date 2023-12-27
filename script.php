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

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obține datele din formular
    $produs = $_POST['produs'];
    $pret_buc = $_POST['pret_buc'];

    // Interogare pentru a afla câte produse există cu același nume și preț pe bucată
    $query = "SELECT NR_CRT, BUCATI, PRET_BUC, PRODUS FROM Table1 WHERE PRODUS = '$produs' AND PRET_BUC = '$pret_buc'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        echo "Nu s-au găsit articole cu aceste caracteristici.";
    } elseif ($result->num_rows == 1) {
        // Există un singur articol
        $row = $result->fetch_assoc();
        //var_dump($row); // Debugging line
        afiseazaArticol($row);
    } elseif ($result->num_rows == 2) {
        // Există două articole cu aceleași caracteristici

        // Obține detaliile articolelor
        $row1 = $result->fetch_assoc();
        $row2 = $result->fetch_assoc();

        // Adună BUCATI de la al doilea articol la primul articol
        $bucati_primul_articol = $row1['BUCATI'] + $row2['BUCATI'];

        // Actualizează primul articol
        $update_query = "UPDATE Table1 SET BUCATI = $bucati_primul_articol WHERE NR_CRT = " . $row1['NR_CRT'];
        $conn->query($update_query);

        // Șterge al doilea articol
        $delete_query = "DELETE FROM Table1 WHERE NR_CRT = " . $row2['NR_CRT'];
        $conn->query($delete_query);

        // Reface NR_CRT pentru articolele următoare articolului șters
        $update_nr_crt_query = "UPDATE Table1 SET NR_CRT = NR_CRT - 1 WHERE NR_CRT > " . $row2['NR_CRT'];
        $conn->query($update_nr_crt_query);

        // Recalculează PRET_TOTAL pentru primul articol
        $pret_total_primul_articol = $bucati_primul_articol * $row1['PRET_BUC'];
        $update_pret_total_query = "UPDATE Table1 SET PRET_TOTAL = $pret_total_primul_articol WHERE NR_CRT = " . $row1['NR_CRT'];
        $conn->query($update_pret_total_query);

        // Afișează primul articol
        echo "<h2>Articolul rămas:</h2>";
        afiseazaArticol($row1);
    }
}

// Funcție pentru a afișa detaliile unui articol într-un tabel
function afiseazaArticol($row) {
    echo "<table border='1'>";
    echo "<tr><th>NR_CRT</th><th>PRODUS</th><th>BUCATI</th><th>PRET_BUC</th><th>PRET_TOTAL</th></tr>";
    echo "<tr><td>{$row['NR_CRT']}</td><td>" . ($row['PRODUS'] ?? 'N/A') . "</td><td>{$row['BUCATI']}</td><td>{$row['PRET_BUC']}</td><td>" . ($row['BUCATI'] * $row['PRET_BUC']) . "</td></tr>";
    echo "</table>";
}

// Închide conexiunea la baza de date
$conn->close();
?>
