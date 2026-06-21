<?php
include 'connect.php';

$uspjesnaPrijava = false;
$admin = false;
$imeKorisnika = '';
$poruka = '';

if (isset($_SESSION['username']) && isset($_SESSION['razina'])) {
    $uspjesnaPrijava = true;
    $imeKorisnika = $_SESSION['username'];
    $admin = ($_SESSION['razina'] == 1);
}

if (isset($_POST['prijava'])) {
    $prijavaIme = isset($_POST['username']) ? $_POST['username'] : '';
    $prijavaLozinka = isset($_POST['lozinka']) ? $_POST['lozinka'] : '';
    
    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaIme);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
        mysqli_stmt_fetch($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($prijavaLozinka, $lozinkaKorisnika)) {
            $uspjesnaPrijava = true;
            $admin = ($levelKorisnika == 1);
            
            $_SESSION['username'] = $imeKorisnika;
            $_SESSION['razina'] = $levelKorisnika;
        } else {
            $poruka = 'Neispravno korisničko ime ili lozinka!';
        }
    }
}

if (isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    $query = "DELETE FROM vijesti WHERE id = $id";
    mysqli_query($dbc, $query);
    header('Location: administrator.php');
    exit();
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $title = mysqli_real_escape_string($dbc, $_POST['title']);
    $about = mysqli_real_escape_string($dbc, $_POST['about']);
    $content = mysqli_real_escape_string($dbc, $_POST['content']);
    $category = mysqli_real_escape_string($dbc, $_POST['category']);
    $subcategory = mysqli_real_escape_string($dbc, $_POST['subcategory']);
    $archive = isset($_POST['archive']) ? 1 : 0;
    
    $full_category = $category . ' / ' . $subcategory;
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0 && !empty($_FILES['photo']['name'])) {
        $image = $_FILES['photo']['name'];
        $target_dir = UPLPATH . $image;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir);
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$image', kategorija='$full_category', arhiva='$archive' WHERE id=$id";
    } else {
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', kategorija='$full_category', arhiva='$archive' WHERE id=$id";
    }
    
    mysqli_query($dbc, $query);
    header('Location: administrator.php');
    exit();
}

if (isset($_GET['odjava'])) {
    session_destroy();
    header('Location: administrator.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sworn to Death - Administracija</title>
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
            <h2 class="artikltitl">Administracija</h2>
        </div>
    </div>

    <section class="content">
        <div class="container">
            
            <?php if ($uspjesnaPrijava && $admin): ?>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="artikl3titl">Dobrodošli, <?php echo htmlspecialchars($imeKorisnika); ?>!</h3>
                    <a href="administrator.php?odjava=1" class="btn-reset">Odjava</a>
                </div>
                
                <h3 class="artikl3titl">Upravljanje vijestima</h3>
                
                <?php
                $query = "SELECT * FROM vijesti ORDER BY id DESC";
                $result = mysqli_query($dbc, $query);
                
                while($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="admin-item" style="border-bottom: 2px solid #eee; padding: 20px 0;">
                        <form enctype="multipart/form-data" action="administrator.php" method="POST">
                            <div class="form-item">
                                <label for="title">Naslov vijesti:</label>
                                <div class="form-field">
                                    <input type="text" name="title" class="form-field-textual" value="<?php echo htmlspecialchars($row['naslov']); ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label for="about">Kratki sažetak:</label>
                                <div class="form-field">
                                    <textarea name="about" cols="30" rows="3" class="form-field-textual" required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label for="content">Tekst vijesti:</label>
                                <div class="form-field">
                                    <textarea name="content" cols="30" rows="5" class="form-field-textual" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label for="category">Kategorija:</label>
                                <div class="form-field">
                                    <select name="category" class="form-field-textual">
                                        <option value="Novosti" <?php if(strpos($row['kategorija'], 'Novosti') !== false) echo 'selected'; ?>>Novosti</option>
                                        <option value="Merch" <?php if(strpos($row['kategorija'], 'Merch') !== false) echo 'selected'; ?>>Merch</option>
                                        <option value="Koncerti" <?php if(strpos($row['kategorija'], 'Koncerti') !== false) echo 'selected'; ?>>Koncerti</option>
                                        <option value="Izdanja" <?php if(strpos($row['kategorija'], 'Izdanja') !== false) echo 'selected'; ?>>Izdanja</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label for="subcategory">Podkategorija:</label>
                                <div class="form-field">
                                    <select name="subcategory" class="form-field-textual">
                                        <option value="Album" <?php if(strpos($row['kategorija'], 'Album') !== false) echo 'selected'; ?>>Album</option>
                                        <option value="Singl" <?php if(strpos($row['kategorija'], 'Singl') !== false) echo 'selected'; ?>>Singl</option>
                                        <option value="Koncert" <?php if(strpos($row['kategorija'], 'Koncert') !== false) echo 'selected'; ?>>Koncert</option>
                                        <option value="Ostalo" <?php if(strpos($row['kategorija'], 'Ostalo') !== false) echo 'selected'; ?>>Ostalo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label for="photo">Slika:</label>
                                <div class="form-field">
                                    <input type="file" class="input-text" name="photo" accept="image/*">
                                    <?php if (!empty($row['slika'])): ?>
                                        <br><img src="<?php echo UPLPATH . $row['slika']; ?>" style="max-width: 150px; margin-top: 10px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label>Arhiva:</label>
                                <div class="form-field checkbox-field">
                                    <input type="checkbox" name="archive" <?php if($row['arhiva'] == 1) echo 'checked'; ?>>
                                    Arhiviraj
                                </div>
                            </div>
                            
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            
                            <div class="form-item">
                                <button type="submit" name="update" class="btn-submit">Izmjeni</button>
                                <button type="submit" name="delete" class="btn-reset" onclick="return confirm('Jeste li sigurni?')">Izbriši</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
                
            <?php elseif ($uspjesnaPrijava && !$admin): ?>
                <h3 class="artikl3titl">Bok <?php echo htmlspecialchars($imeKorisnika); ?>!</h3>
                <p style="color: red; font-size: 18px;">Uspješno ste prijavljeni, ali nemate administratorska prava!</p>
                <p><a href="administrator.php?odjava=1">Odjava</a></p>
                
            <?php else: ?>
                <h3 class="artikl3titl">Prijava u administraciju</h3>
                
                <?php if (!empty($poruka)): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($poruka); ?></p>
                <?php endif; ?>
                
                <form action="administrator.php" method="POST">
                    <div class="form-item">
                        <label for="username">Korisničko ime:</label>
                        <div class="form-field">
                            <input type="text" name="username" id="username" class="form-field-textual" required>
                        </div>
                    </div>
                    
                    <div class="form-item">
                        <label for="lozinka">Lozinka:</label>
                        <div class="form-field">
                            <input type="password" name="lozinka" id="lozinka" class="form-field-textual" required>
                        </div>
                    </div>
                    
                    <div class="form-item">
                        <button type="submit" name="prijava" class="btn-submit">Prijavi se</button>
                        <a href="registracija.php" class="btn-reset">Registriraj se</a>
                    </div>
                </form>
                
            <?php endif; ?>
            
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