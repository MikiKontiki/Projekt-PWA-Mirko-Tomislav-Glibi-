<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sworn to Death - Kategorija</title>
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
            <?php
            $kategorija = isset($_GET['kategorija']) ? mysqli_real_escape_string($dbc, $_GET['kategorija']) : 'Novosti';
            echo '<h2 class="artikltitl">Kategorija: ' . htmlspecialchars($kategorija) . '</h2>';
            ?>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="artikli">
                <?php
                $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija LIKE '%$kategorija%' ORDER BY id DESC";
                $result = mysqli_query($dbc, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        echo '<article>';
                        if (!empty($row['slika'])) {
                            echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        }
                        echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a></h3>';
                        echo '<p>' . htmlspecialchars($row['sazetak']) . '</p>';
                        echo '<p class="datum">' . $row['datum'] . '</p>';
                        echo '</article>';
                    }
                } else {
                    echo '<p>Nema vijesti u ovoj kategoriji.</p>';
                }
                
                mysqli_close($dbc);
                ?>
            </div>
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