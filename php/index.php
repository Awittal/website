<?php
$host = '89.58.47.144'; // Dein Hostname
$user = '2GIN'; // Dein Benutzername
$password = '!43L[rjz4Dj64o5v'; // Dein Passwort
$dbname = 'dbSchule'; // Der Name deiner Datenbank

$dtVideo;
$dtImage;
// Verbindung zur Datenbank herstellen
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage ausführen
$sql = "SELECT dtVideo, dtImage FROM tblVideos_ChristianBeats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Schleife über die Ergebnisdaten
    while ($row = $result->fetch_assoc()) {
        $dtVideo = $row["dtVideo"];
        $dtImage = $row["dtImage"];

    }
} else {
    echo "Keine Ergebnisse gefunden.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Überprüfe, ob der Like-Button geklickt wurde
    if (isset($_POST['like'])) {
        $id = $_POST['like']; // Die ID des Elements, das geliked wurde
        $likes[] = $id; // Füge die ID zum $likes Array hinzu

        // Aktualisiere den Wert in der Datenbank
        $stmt = $mysqli->prepare('UPDATE deine_tabelle SET dtLikes = ? WHERE id = ?');
        $stmt->bind_param('si', serialize($likes), $id);
        $stmt->execute();
        $stmt->close();
    }

    // Überprüfe, ob der Dislike-Button geklickt wurde
    if (isset($_POST['dislike'])) {
        $id = $_POST['dislike']; // Die ID des Elements, das dislikt wurde
        $dislikes[] = $id; // Füge die ID zum $dislikes Array hinzu

        // Aktualisiere den Wert in der Datenbank
        $stmt = $mysqli->prepare('UPDATE deine_tabelle SET dtDislikes = ? WHERE id = ?');
        $stmt->bind_param('si', serialize($dislikes), $id);
        $stmt->execute();
        $stmt->close();
    }
}
// Schließe die Verbindung zur Datenbank
$mysqli->close();
?>



?>
<!DOCTYPE html>
<html>
<body>



    <h1>Bilder Liken und Disliken</h1>
    <table>
        <link rel="stylesheet" href="../styles/styles-likeDislike.css" />
        <?php
        // Erstelle das Grid von 5 * 2 Bildern
        $counter = 0;
            for ($i = 0; $i < 2; $i++) {
                echo "<tr>";
                for ($j = 0; $j < 5; $j++) {
                    $id = $counter++;
                    echo "<td>";
                    echo "<a href='$dtVideo[$id]'><img src='$$dtImage[$id]' alt='Bild $id' /></a>";
                    echo "<br />";
                    echo "<form method='post'>";
                    echo "<button type='submit' name='like' value='$id'>Like</button>";
                    echo "<button type='submit' name='dislike' value='$id'>Dislike</button>";
                    echo "</form>";
                    echo "<br />";
                    echo "<span class='likes'>Likes: </span>";
                    echo "<span id='like$id' class='likes'>$likes[$id]</span> ";
                    echo "<br />";
                    echo "<span class='likes'>Dislike: </span>";
                    echo "<span id='dislike$id' class='likes'>$dislikes[$id]</span>";
                    echo "</td>";
                    echo "<script>";
                    echo "var like$id = document.getElementById('like$id');";
                    echo "var dislike$id = document.getElementById('dislike$id');";
                    echo "like$id.innerHTML = $likes[$id];";
                    echo "dislike$id.innerHTML = $dislikes[$id];";
                    echo "</script>";
                 }
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>

