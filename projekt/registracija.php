<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = isset($_POST['ime']) ? $_POST['ime'] : '';
    $prezime = isset($_POST['prezime']) ? $_POST['prezime'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $lozinka = isset($_POST['pass']) ? $_POST['pass'] : '';
    $lozinkaRep = isset($_POST['passRep']) ? $_POST['passRep'] : '';
    
    if ($lozinka !== $lozinkaRep) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $hashed_password = password_hash($lozinka, PASSWORD_DEFAULT);
        $razina = 0;
        
        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <title>Sworn to Death - Registracija</title>
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
            <h2 class="artikltitl">Registracija korisnika</h2>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <article>
                <?php if ($registriranKorisnik == true): ?>
                    <h3 style="color: green;">Korisnik je uspješno registriran!</h3>
                    <p><a href="administrator.php">Idi na prijavu</a></p>
                <?php else: ?>
                    <h3 class="artikl3titl">Unesite podatke za registraciju</h3>
                    
                    <?php if (!empty($msg)): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($msg); ?></p>
                    <?php endif; ?>
                    
                    <form action="registracija.php" method="POST">
                        <div class="form-item">
                            <label for="ime">Ime:</label>
                            <div class="form-field">
                                <input type="text" name="ime" id="ime" class="form-field-textual" required>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <label for="prezime">Prezime:</label>
                            <div class="form-field">
                                <input type="text" name="prezime" id="prezime" class="form-field-textual" required>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <label for="username">Korisničko ime:</label>
                            <div class="form-field">
                                <input type="text" name="username" id="username" class="form-field-textual" required>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <label for="pass">Lozinka:</label>
                            <div class="form-field">
                                <input type="password" name="pass" id="pass" class="form-field-textual" required>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <label for="passRep">Ponovite lozinku:</label>
                            <div class="form-field">
                                <input type="password" name="passRep" id="passRep" class="form-field-textual" required>
                            </div>
                        </div>
                        
                        <div class="form-item">
                            <button type="submit" class="btn-submit">Registriraj se</button>
                            <a href="administrator.php" class="btn-reset">Već imam račun</a>
                        </div>
                    </form>
                <?php endif; ?>
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