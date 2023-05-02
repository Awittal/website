<?php
// Initialisiere die Anzahl der Likes und Dislikes
$likes = array(0,0,0,0,0,0,0,0,0,0);
$dislikes = array(0,0,0,0,0,0,0,0,0,0);

// Erstelle eine ArrayListe von Bildern
$images = array(
    'https://www.catipilla.com/wp-content/uploads/2023/02/test-clip-art-cpa-school-test.png',
    'https://www.testim.io/wp-content/uploads/2019/11/Testim-What-is-a-Test-Environment_-A-Guide-to-Managing-Your-Testing-A.png',
    'data:image/png;base64,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', 
    'https://alamocitygolftrail.com/wp-content/uploads/2022/11/canstockphoto22402523-arcos-creator.com_-1024x1024-1.jpg',
    'https://images.sftcdn.net/images/t_app-cover-l,f_auto/p/ce2ece60-9b32-11e6-95ab-00163ed833e7/260663710/the-test-fun-for-friends-screenshot.jpg',
    'https://upload.wikimedia.org/wikipedia/commons/thumb/d/df/Test.de.svg/1200px-Test.de.svg.png',
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdSblXAfSgbFP9ch47hT9Ol4ghqwxk3r3Z1A&usqp=CAU',
    'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bd/Test.svg/2560px-Test.svg.png',
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8P868rGIj_xg7gE0AkzfhE5qhI-CpRGLyKQ&usqp=CAU',
    'https://pbs.twimg.com/profile_images/1498641868397191170/6qW2XkuI_400x400.png'
);

// Überprüfe, ob ein Button gedrückt wurde
if (isset($_POST['like'])) {
    $id = $_POST['like'];
    if (isset($likes[$id])) {
        $likes[$id]++;
    } else {
        $likes[$id] = 1;
    }
}

if (isset($_POST['dislike'])) {
    $id = $_POST['dislike'];
    if (isset($dislikes[$id])) {
        $dislikes[$id]++;
    } else {
        $dislikes[$id] = 1;
    }
}
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
                echo "<td><img src='$images[$id]' alt='Bild $id'>";
                echo "<br>";
                echo "<form method='post'>";
                echo "<button type='submit' name='like' value='$id'>Like</button>";
                echo "<button type='submit' name='dislike' value='$id'>Dislike</button>";
                echo "</form>";
                echo "<br>";
                echo "<span class='likes'>Likes: </span>";
                echo "<span id='like$id' class='likes'>$likes[$id] </span> ";
                echo "<br>";
                echo "<span class='likes'>        Dislike: </span>";
                echo "<span id='dislike$id' class='likes' >$dislikes[$id]</span>";
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

