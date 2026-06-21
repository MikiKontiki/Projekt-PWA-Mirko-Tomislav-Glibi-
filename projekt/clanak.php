<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sworn to Death - Članak</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <a href="index.php"><img src="img/logo.png" alt="Sworn to Death logo"></a>
                    <li><a href="index.php">Novosti</a></li>
                    <li><a href="index.php#merch">Merch</a></li>
                    <li><a href="Bio.html">Bio</a></li>
                    <li><a href="unos.php">Unos</a></li>
                    <li><a href="administrator.php">Admin</a></li>
                    <li><a href="kategorija.php?kategorija=Novosti">Novosti</a></li>
                    <li><a href="kategorija.php?kategorija=Koncerti">Koncerti</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="bojaartikla">
        <div class="container">
            <h2 class="artikltitl">Članak</h2>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($id > 0) {
                $query = "SELECT * FROM vijesti WHERE id = $id";
                $result = mysqli_query($dbc, $query);
                $row = mysqli_fetch_array($result);
                
                if ($row) {
                    echo '<article>';
                    echo '<p class="category">Kategorija: ' . htmlspecialchars($row['kategorija']) . '</p>';
                    echo '<h1 class="title">' . htmlspecialchars($row['naslov']) . '</h1>';
                    
                    if (!empty($row['slika'])) {
                        echo '<div class="slika">';
                        echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '" style="max-width:100%;">';
                        echo '</div>';
                    }
                    
                    echo '<div class="about">';
                    echo '<p><strong>Sažetak:</strong></p>';
                    echo '<p>' . nl2br(htmlspecialchars($row['sazetak'])) . '</p>';
                    echo '</div>';
                    
                    echo '<div class="sadrzaj">';
                    echo '<p>' . nl2br(htmlspecialchars($row['tekst'])) . '</p>';
                    echo '</div>';
                    
                    echo '<div class="info">';
                    echo '<p>Objavljeno: ' . $row['datum'] . '</p>';
                    echo '</div>';
                    
                    echo '<a href="index.php" class="back-link">← Natrag na početnu</a>';
                    echo '</article>';
                } else {
                    echo '<p>Članak nije pronađen.</p>';
                }
            } else {
                echo '<p>Neispravan ID članka.</p>';
            }
            
            mysqli_close($dbc);
            ?>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Mirko Tomislav Glibić</p>
            <p>mglibic@tvz.hr</p>
            <p>2026</p>
        </div>
    </footer>
</body>
</html>