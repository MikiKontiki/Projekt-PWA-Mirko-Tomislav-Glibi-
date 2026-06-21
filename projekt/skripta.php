<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $about = isset($_POST['about']) ? $_POST['about'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $archive = isset($_POST['archive']) ? 'Da' : 'Ne';
    
    $image = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : 'default.jpg';
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sworn to Death - Pregled vijesti</title>
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
            <h2 class="artikltitl">Pregled unesene vijesti</h2>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <article>
                <p class="category">Kategorija: <?php echo htmlspecialchars($category); ?></p>
                <h1 class="title"><?php echo htmlspecialchars($title); ?></h1>
                
                <div class="slika">
                    <?php if (!empty($image)): ?>
                        <img src="img/<?php echo htmlspecialchars($image); ?>" alt="Slika vijesti" style="max-width:100%;">
                    <?php else: ?>
                        <p><em>Nema odabrane slike</em></p>
                    <?php endif; ?>
                </div>

                <div class="about">
                    <p><strong>Sažetak:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($about)); ?></p>
                </div>

                <div class="sadrzaj">
                    <p><strong>Tekst vijesti:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
                </div>

                <div class="info">
                    <p><strong>Prikaži na stranici:</strong> <?php echo $archive; ?></p>
                </div>

                <a href="Index.html" class="back-link">← Natrag na početnu</a>
            </article>
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