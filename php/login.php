<?php
// Verbindung zur Datenbank herstellen
$servername = "89.58.47.144";
$username = "2GIN";
$password = "!43L[rjz4Dj64o5v";
$dbname = "dbSchule";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Benutzername und Passwort aus dem Formular abrufen
$username = $_POST['dtUsername'];
$password = $_POST['dtPasswort'];

// Benutzer in der Datenbank überprüfen
$sql = "SELECT * FROM tblUsers_ChristianBeats WHERE dtUsername = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Benutzer gefunden, Überprüfung des Passworts
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['dtPasswort'])) {
        // Passwort stimmt überein, Benutzer erfolgreich eingeloggt
        echo "Login erfolgreich!";
        // Weitere Aktionen durchführen oder zur Startseite weiterle
    }
}
?>