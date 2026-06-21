<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = isset($_POST['title']) ? mysqli_real_escape_string($dbc, $_POST['title']) : '';
    $about = isset($_POST['about']) ? mysqli_real_escape_string($dbc, $_POST['about']) : '';
    $content = isset($_POST['content']) ? mysqli_real_escape_string($dbc, $_POST['content']) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($dbc, $_POST['category']) : '';
    $subcategory = isset($_POST['subcategory']) ? mysqli_real_escape_string($dbc, $_POST['subcategory']) : '';
    
    $archive = isset($_POST['archive']) ? 1 : 0;
    
    $date = date('d.m.Y.');
    
    $image = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0 && !empty($_FILES['photo']['name'])) {
        $image = $_FILES['photo']['name'];
        $target_dir = UPLPATH . $image;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir);
    }
    
    $full_category = $category . ' / ' . $subcategory;
    
    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) 
              VALUES ('$date', '$title', '$about', '$content', '$image', '$full_category', '$archive')";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database: ' . mysqli_error($dbc));
    
    mysqli_close($dbc);
    
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <title>Sworn to Death - Unos vijesti</title>
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
                </ul>
            </nav>
        </div>
    </header>

    <div class="bojaartikla">
        <div class="container">
            <h2 class="artikltitl">Unos vijesti</h2>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <article>
                <h3 class="artikl3titl">Unesite podatke o novoj vijesti</h3>
                
                <form action="unos.php" method="POST" enctype="multipart/form-data">
                    <div class="form-item">
                        <label for="title">Naslov vijesti</label>
                        <div class="form-field">
                            <input type="text" name="title" id="title" class="form-field-textual" required>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="about">Kratki sažetak vijesti</label>
                        <div class="form-field">
                            <textarea name="about" id="about" cols="30" rows="5" class="form-field-textual" required></textarea>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="content">Tekst vijesti</label>
                        <div class="form-field">
                            <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual" required></textarea>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="category">Kategorija vijesti</label>
                        <div class="form-field">
                            <select name="category" id="category" class="form-field-textual">
                                <option value="Novosti">Novosti</option>
                                <option value="Merch">Merch</option>
                                <option value="Koncerti">Koncerti</option>
                                <option value="Izdanja">Izdanja</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="subcategory">Podkategorija</label>
                        <div class="form-field">
                            <select name="subcategory" id="subcategory" class="form-field-textual">
                                <option value="Album">Album</option>
                                <option value="Singl">Singl</option>
                                <option value="Koncert">Koncert</option>
                                <option value="Ostalo">Ostalo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="photo">Odaberi sliku</label>
                        <div class="form-field">
                            <input type="file" name="photo" id="photo" accept="image/*" class="input-text">
                        </div>
                    </div>

                    <div class="form-item">
                        <label>
                            <div class="form-field checkbox-field">
                                <input type="checkbox" name="archive" value="1" checked>
                                Prikaži na stranici
                            </div>
                        </label>
                    </div>

                    <div class="form-item">
                        <button type="reset" class="btn-reset">Poništi</button>
                        <button type="submit" class="btn-submit">Objavi vijest</button>
                    </div>
                </form>
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