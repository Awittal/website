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
$sql = "SELECT dtVideo, dtImage, dtLikes, dtDislikes FROM tblVideos_ChristianBeats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Schleife über die Ergebnisdaten
    while ($row = $result->fetch_assoc()) {
        $dtVideo[] = $row["dtVideo"];
        $dtImage[] = $row["dtImage"];
        $dtLikes[] = $row["dtLikes"];
        $dtDislikes[] = $row["dtDislikes"];
    }
} else {
    echo "Keine Ergebnisse gefunden.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Überprüfe, ob der Like-Button geklickt wurde
    if (isset($_POST['like'])) {
        $id = $_POST['like']; // Die ID des Elements, das geliked wurde
        $dtLikes[$id-1] += 1 ; // Füge die ID zum $dtLikes Array hinzu

        // Aktualisiere den Wert in der Datenbank
        $stmt = $conn->prepare('UPDATE tblVideos_ChristianBeats SET dtLikes = dtLikes+1 WHERE idImage_Video = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();


    }

    // Überprüfe, ob der Dislike-Button geklickt wurde
    if (isset($_POST['dislike'])) {
        $id = $_POST['dislike']; // Die ID des Elements, das dislikt wurde
        $dtDislikes[$id-1] += 1 ; // Füge die ID zum $dtDislikes Array hinzu

        // Aktualisiere den Wert in der Datenbank
        $stmt = $conn->prepare('UPDATE tblVideos_ChristianBeats SET dtDislikes = dtDislikes+1 WHERE idImage_Video = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}



// Schließe die Verbindung zur Datenbank
$conn->close();
?>
<script>
function openVideo(videoUrl) {
     window.open(videoUrl, '_blank');
}
</script>


<!DOCTYPE html>
<html>
<body>
    <h1>Bilder Liken und Disliken</h1>
    <table>
        <link rel="stylesheet" href="../styles/styles-likeDislike.css" />
        <?php
        // Erstelle das Grid von 5 * 2 Bildern
        $counter = 0;
        for ($i = 0; $i < ceil($anzahlRows / 5); $i++) {
            echo "<tr>";
            for ($j = 0; $j < 5 && $counter < $anzahlRows; $j++) {
                $counter++;
                $id = $counter - 1;
                echo "<td>";
                echo "<a onclick='openVideo(\"" . $dtVideo[$id] . "\")'><img src='" . $dtImage[$id] . "' alt='Bild $id' /></a>";
//                echo "<a href='" . $dtVideo[$id] . "'><img src='" . $dtImage[$id] . "' alt='Bild $id' /></a>";
                echo "<br />";
                echo "<form method='post'>";
                echo "<button type='submit' name='like' value='$counter'>Like</button>";
                echo "<button type='submit' name='dislike' value='$counter'>Dislike</button>";
                echo "</form>";
                echo "<br />";
                echo "<span class='likes'>Likes: </span>";
                echo "<span id='like$id' class='likes'>" . $dtLikes[$id] . "</span> ";
                echo "<br />";
                echo "<span class='likes'>Dislikes: </span>";
                echo "<span id='dislike$id' class='likes'>" . $dtDislikes[$id] . "</span>";
                echo "</td>";
                echo "<script>";
                echo "var like$id = document.getElementById('like$id');";
                echo "var dislike$id = document.getElementById('dislike$id');";
                echo "like$id.innerHTML = " . $dtLikes[$id] . ";";
                echo "dislike$id.innerHTML = " . $dtDislikes[$id] . ";";
                echo "</script>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
