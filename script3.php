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
$nume1=$_POST['nume1'];
$nume2=$_POST['nume2'];
$varsta1=$_POST['varsta1'];
$varsta2=$_POST['varsta2'];

//Introducem in baza de date
$sql = "INSERT INTO TABLE2 (NUME, VARSTA) VALUES ('$nume1', '$varsta1'), ('$nume2', '$varsta2')";

if ($conn->multi_query($sql) === TRUE) {
    echo "Articole adăugate cu succes!";
} else {
    echo "Eroare la adăugarea articolelor: " . $conn->error;
}

$query = "SELECT NR_CRT, NUME, VARSTA FROM TABLE2";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Informații din tabel:</h2>";
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