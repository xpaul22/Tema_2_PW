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
$varsta=$_POST['varsta'];

//Interogam baza de date
$query = "SELECT NR_CRT, NUME, VARSTA FROM TABLE2 WHERE VARSTA='$varsta'";
$result = $conn->query($query);

if ($result->num_rows>0){
    echo "<h2>Persoane gasite:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>NR_CRT</th><th>Nume</th><th>Varsta</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $nr_crt = $row['NR_CRT'];
        $nume = $row['NUME'];
        $varsta_db = $row['VARSTA'];
        echo "<tr><td>$nr_crt</td><td>$nume</td><td>$varsta_db</td></tr>";
    }

    echo "</table>";
} else {
    echo "Nu există persoane cu acesta varsta.";
}

?>