<?php

// Ne conectam la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername,$username,$password,$dbname);

// Verificam daca ne-am connectat la baza de date
if ($conn->connect_error){
    die("Conexiune esuata!".$conn->connect_error);
}

//Luam datele introduse in HTML
$nume=$_POST['nume'];
$varsta=$_POST['varsta'];

$sql = "DELETE FROM TABLE2 WHERE NUME = '$nume' AND VARSTA = '$varsta'";
$result = $conn->query($sql);

if ($result === TRUE) {
    $numar_articole_sterse = $conn->affected_rows;
    if ($numar_articole_sterse>0){
        echo "$numar_articole_sterse articole au fost șterse cu succes!";
    }
    else{
        echo "Persoana cu varsta introdusa nu exista in baza de date!";
    }
} else {
    echo "Eroare la ștergerea articolelor: " . $conn->error;
}

$query = "SELECT NR_CRT, NUME, VARSTA FROM TABLE2";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Tabel:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Nr. Crt</th><th>Nume</th><th>Varsta</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $nr_crt = $row['NR_CRT'];
        $nume = $row['NUME'];
        $varsta = $row['VARSTA'];
        echo "<tr><td>$nr_crt</td><td>$nume</td><td>$varsta</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nu există informații în tabel.";
}

$conn->close();

?>