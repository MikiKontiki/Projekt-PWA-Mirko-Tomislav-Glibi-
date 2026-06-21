<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" href="Style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sworn to Death - Zagreb groove metal bend. Novi album Pillars of Morality / Ruins of a Mind.">
    <title>Sworn to Death | Groove Metal Bend</title>
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

    <div class="container">
        <h1>Dobrodošli u Sworn to Death</h1>
    </div>

    <section class="content" id="novosti">
        <div class="container">
            <h2 class="prvititl">Novosti</h2>
            <div class="artikli">
                <?php
                $query = "SELECT * FROM vijesti WHERE arhiva=0 AND (kategorija LIKE '%Novosti%' OR kategorija LIKE '%Izdanja%') ORDER BY id DESC LIMIT 4";
                $result = mysqli_query($dbc, $query);
                
                while($row = mysqli_fetch_array($result)) {
                    echo '<article>';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                    echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a></h3>';
                    echo '<p>' . htmlspecialchars($row['sazetak']) . '</p>';
                    echo '<p class="datum">' . $row['datum'] . '</p>';
                    echo '</article>';
                }
                mysqli_close($dbc);
                ?>
            </div>
        </div>
    </section>

    <section class="content" id="merch">
        <div class="container">
            <h2 class="drugititl">Merch</h2>
            <div class="artikli">
                <article>
                    <img src="img/casa2.png" alt="Šalica crna logo">
                    <a href="Merch1.html"><h3>Šalica crna logo</h3></a>
                    <p>Šalica sa logom benda, idealna za jutarnju kavu ili čaj.</p>
                </article>
                <article>
                    <img src="img/blackshirt2.png" alt="Majica crna album cover">
                    <a href="Merch2.html"><h3>Majica crna album cover</h3></a>
                    <p>Crna majica s logom albuma, savršena za svakodnevno nošenje ili koncerte.</p>
                </article>
                <article>
                    <img src="img/blackshirt.png" alt="Majica crna logo">
                    <a href="Merch3.html"><h3>Majica crna logo</h3></a>
                    <p>Crna majica s logom benda, savršena za svakodnevno nošenje ili koncerte.</p>
                </article>
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