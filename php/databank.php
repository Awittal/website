<?php
$host = '89.58.47.144'; // Dein Hostname
$user = '2GIN'; // Dein Benutzername
$password = '!43L[rjz4Dj64o5v'; // Dein Passwort
$dbname = 'dbSchule'; // Der Name deiner Datenbank

$dtVideo = array();
$dtImage = array();
$dtLikes = array();
$dtDislikes = array();
$anzahlRows = 0;

// Verbindung zur Datenbank herstellen
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) as count FROM tblVideos_ChristianBeats";

// Ausführen der Abfrage
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $anzahlRows = $row['count'];
}

// SQL-Abfrage ausführen
$sql = "SELECT * FROM tblVideos_ChristianBeats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Schleife über die Ergebnisdaten
    while ($row = $result->fetch_assoc()) {
        $dtVideo[] = $row["dtVideo"];
        $dtImage[] = $row["dtImage"];
        $dtLikes[] = $row["dtLikes"];
        $dtDislikes[] = $row["dtDislikes"];
        $id2[] = $row["idImage_Video"];
    }
} else {
    echo "Keine Ergebnisse gefunden.";
}

// Daten, die du anfordern möchtest
$responseData = array();

// Überprüfe, ob die POST-Variablen gesetzt sind
if (isset($_POST['videoRequest']) && $_POST['videoRequest'] === 'getVideo') {
    $responseData['video'] = $dtVideo;
}
if (isset($_POST['imageRequest']) && $_POST['imageRequest'] === 'getImage') {
    $responseData['image'] = $dtImage;
}
if (isset($_POST['likesRequest']) && $_POST['likesRequest'] === 'getLikes') {
    $responseData['likes'] = $dtLikes;
}
if (isset($_POST['dislikesRequest']) && $_POST['dislikesRequest'] === 'getDislikes') {
    $responseData['dislikes'] = $dtDislikes;
}
if (isset($_POST['anzahlRequest']) && $_POST['anzahlRequest'] === 'getRows') {
    $responseData['rows'] = $anzahlRows;
}

// Sende die Daten als JSON-Antwort zurück an das erste Skript
header('Content-Type: application/json');
echo json_encode($responseData);

// Überprüfe, ob der Like-Button geklickt wurde
if (isset($_POST['like'])) {
    $id3 = $_POST['like']; // Die ID des Elements, das geliked wurde
    $dtLikes[$id3] += 1;

    // Aktualisiere den Wert in der Datenbank
    $stmt = $conn->prepare('UPDATE tblVideos_ChristianBeats SET dtLikes = dtLikes+1 WHERE idImage_Video = ?');
    $stmt->bind_param('i', $id3);
    $stmt->execute();
    $stmt->close();
}

// Überprüfe, ob der Dislike-Button geklickt wurde
else if (isset($_POST['dislike'])) {
    $id4 = $_POST['dislike']; // Die ID des Elements, das dislikt wurde
    $dtDislikes[$id4] += 1; // Füge die ID zum $dtDislikes Array hinzu

    // Aktualisiere den Wert in der Datenbank
    $stmt = $conn->prepare('UPDATE tblVideos_ChristianBeats SET dtDislikes = dtDislikes+1 WHERE idImage_Video = ?');
    $stmt->bind_param('i', $id4);
    $stmt->execute();
    $stmt->close();
}

// Schließe die Verbindung zur Datenbank
$conn->close();
header("Refresh:0; url=index.php");
?>
