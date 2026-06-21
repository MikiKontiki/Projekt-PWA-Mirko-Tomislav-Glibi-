<?php
$lozinka = 'user123';
$hash = password_hash($lozinka, PASSWORD_DEFAULT);
echo 'Lozinka: ' . $lozinka . '<br>';
echo 'Hash: ' . $hash;
?>